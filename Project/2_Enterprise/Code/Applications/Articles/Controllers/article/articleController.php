<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'articleView.php';

require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'Project/Model/Articles/article.php';
require_once 'Project/Model/Articles/articles.php';
require_once 'Project/Model/Articles/article_image.php';
require_once 'Project/Model/Articles/article_images.php';
require_once 'Project/Model/Articles/article_tags.php';
require_once 'Project/Model/Articles/article_tag.php';
require_once 'Project/Model/Routes/route.php';

require_once 'Project/Model/Articles/article_element.php';

class articleController extends applicationsSuperController
{
	private $url_parameter;
	public function __construct()
	{
		parent::__construct();
		
		require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Controllers/images/imagesView.php';
		$images = new imagesView();
		$images->getPhotoChooser();
	}
	
	public function indexAction()
	{
		$article = new article();
		$article->selectFirst();
		
		$this->editAction($article->__get('article_id'));
		
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function addAction()
	{
		print ('<pre>');
		var_dump($_POST);
		die;
		$route			= new route();
		$article		= new article();
		
		if(isset($_POST['title']) && isset($_POST['add_article']))
		{
			//start SQL transaction
			/* NOTE: SQL transactions should be used when a combination of insert, update
			 * and delete commands is executed
			 */
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
			
			//insert routing details
			$route->__set('permalink', $this->replaceChars($_POST['title']));
			$route->insert();
			
			$category_id	= is_numeric($_POST['category_id']) ? $_POST['category_id'] : NULL;
			$subcategory_id = is_numeric($_POST['subcategory_id']) ? $_POST['subcategory_id'] : NULL;
			
			//insert article details
			$article->__set('route_id', $route->__get('route_id'));
			$article->__set('category_id', $category_id);
			$article->__set('subcategory_id',$subcategory_id);
			$article->__set('article_title', $_POST['title']);
			$article->insert();
			
			$pdo_connection->commit();
			
			header('Location: /articles/action/edit/'.$article->__get('article_id'));
		}
		
		else
			header('Location: /articles');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function editAction($article_id = NULL)
	{
		if($article_id === NULL)
			$article_id = $this->getValueOfURLParameterPair('edit');
		
		if(is_numeric($article_id))
		{	
			$route			= new route();
			$article		= new article();
			$article_image	= new article_images();
			$article_tags	= new article_tags();
			$article_tag	= new article_tag();
			
			$article_elements = new articleElements();
			
			$article->__set('article_id', $article_id);
			$article->select();
			
			$article_elements->select($article_id);
			
			$article_tags->__set('article_id', $article_id);
			$article_tags->select();
			
			if(isset($_POST['edit_article']))
			{
				
				//start SQL transaction
				/* NOTE: SQL transactions should be used when a combination of insert, update
				 * and delete commands is executed
				 */
				$pdo_connection = starfishDatabase::getConnection();
				$pdo_connection->beginTransaction();
				
				//update routing details
				$route->__set('route_id', $article->__get('route_id'));
				$route->__set('permalink', $this->replaceChars($_POST['permalink']));
				$route->update();
				
				//update article details
				$article->__set('article_title', $_POST['title']);
				$article->__set('status', $_POST['status']);
				$article->update();
				
				//update tags
				$orig_tags	= $article_tags->__get('array_of_tags');
				$tags		= explode(',', str_replace(', ',',', $_POST['tags']));
				$remain_tags = array();
				
				//update images
				//$this->handleImages($article_id, 'gallery_image_id');
				$this->insertElements($article_id, $_POST['element']);
				
				foreach($orig_tags as $tag)
					if(!in_array($tag, $tags))
						article_tag::delete($article_id, $tag);
					else
						$remain_tags[] = $tag;
					
				
				foreach($tags as $tag)
					if(!in_array($tag, $remain_tags))
						article_tag::insert($article_id, trim($tag));
			
			$pdo_connection->commit();
				header('Location: /articles/action/edit/'.$article_id);
			}
			
			else
			{
				$tags = implode(', ', $article_tags->__get('array_of_tags'));
				$article_images = article_images::selectThumbnailByType($article_id);
				
				$view = new articleView();
				$view->_set('tags', $tags);
				$view->_set('article', $article);
				$view->_set('article_elements', $article_elements->getArrayOfArticleElements());
				$view->_set('article_images', $article_images);
				$view->displayArticleEditor();
			}
		}
		
		else
		{
			$view = new articleView();
			$view->_set('tags', new article_tags());
			$view->_set('article', new article());
			$view->displayArticleEditor();
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function deleteAction()
	{	
		$article_id = $this->getValueOfURLParameterPair('delete');
		
		if(is_numeric($article_id))
		{
			//start SQL transaction
			/* NOTE: SQL transactions should be used when a combination of insert, update
			 * and delete commands is executed
			 */
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
				
			$route			= new route();
			$article		= new article();
			
			$article->__set('article_id', $article_id);
			$article->select();
			
			//delete routing details
			$route->__set('route_id', $article->__get('route_id'));
			$route->delete();
			
			//delete article details
			article::delete($article_id);
			
			$pdo_connection->commit();
		}
		
		header('Location: /articles');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	private function replaceChars($permalink)
	{
		$characters = array(' ','_',',','\'','.',':',';','?','!');
		
		$string = strtolower(str_replace($characters, '-', $permalink));
		
		return trim($string, '-');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	private function handleImages($article_id, $post_key)
	{
		if(isset($_POST[$post_key]))
		{
			$i = 0;
			
			//delete
			foreach(article_images::selectArticleImageIDs($article_id) as $id)
				if(!in_array($id, $_POST[$post_key]))
					article_image::delete($id);
			
			foreach($_POST[$post_key] as $value)
			{
				if($_POST['image_id'][$i] != '' || $_POST['image_id'][$i] != NULL)
				{
					$article_image	= new article_image();
					$article_image->__set('article_id', $article_id);
					$article_image->__set('image_id', $_POST['image_id'][$i]);
					$article_image->__set('used_for', 'gallery');
		
					//add
					if($value == 0)
						$article_image->insert();
					
					//update
					else
					{
						$article_image->__set('article_image_id', $value);
						$article_image->update();
					}
				}
				//var_dump($article_image);
				
				$i++;
			}
		}
		else
			article_images::deleteByArticleID($article_id);
	}
	
//-------------------------------------------------------------------------------------------------

	private function insertElements($article_id, $elements = array())
	{
		/* print (count($elements).'<pre>');
		var_dump($elements);
		die; */
		$article_element_model = new articleElement();
		$article_element_model->setArticleId($article_id);
		$article_element_model->delete();
		
		for ($x = 0; $x <= count($elements); $x++)
		{
			if ($x % 2 == 0)
			{
				if ($elements[$x] == 'text')
				{
					$article_element_model->setArticleElementType('text');
					$article_element_model->setArticleElementContent($elements[$x+1]);
					$article_element_model->insert();
				}
				elseif ($elements[$x] == 'image')
				{
					$article_element_model->setArticleElementType('image');
					$article_element_model->setArticleElementContent($elements[$x+1]);
					//die($elements[$x+1]);
					$article_element_model->insert();
				}
		
			}
		}
	}

}


