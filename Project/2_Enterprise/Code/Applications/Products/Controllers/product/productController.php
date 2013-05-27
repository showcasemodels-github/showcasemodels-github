<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'productView.php';

require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'Project/Model/Products/product.php';
require_once 'Project/Model/Products/products.php';
require_once 'Project/Model/Products/product_image.php';
require_once 'Project/Model/Products/product_images.php';
require_once 'Project/Model/Routes/route.php';

class productController extends applicationsSuperController
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
		$product = new product();
		$product->selectFirst();
		
		$this->editAction($product->__get('product_id'));
		
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function addAction()
	{
		$route			= new route();
		$product		= new product();
		
		if(isset($_POST['title']) && isset($_POST['add_product']))
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
			
			//insert product details
			$product->__set('route_id', $route->__get('route_id'));
			$product->__set('category_id', $category_id);
			$product->__set('subcategory_id',$subcategory_id);
			$product->__set('product_title', $_POST['title']);
			$product->__set('description', $_POST['intro']);
			$product->insert();
			
			$pdo_connection->commit();
			
			header('Location: /products/product/edit/'.$product->__get('product_id'));
		}
		
		else
			header('Location: /products');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function editAction($product_id = NULL)
	{
		if($product_id === NULL)
			$product_id = $this->getValueOfURLParameterPair('edit');
		
		if(is_numeric($product_id))
		{	
			$route			= new route();
			$product		= new product();
			$product_image	= new product_images();
// 			$product_tags	= new product_tags();
// 			$product_tag	= new product_tag();
			
			$product->__set('product_id', $product_id);
			$product->select();
			
// 			$product_tags->__set('product_id', $product_id);
// 			$product_tags->select();
			
			if(isset($_POST['edit_product']))
			{
				//start SQL transaction
				/* NOTE: SQL transactions should be used when a combination of insert, update
				 * and delete commands is executed
				 */
				$pdo_connection = starfishDatabase::getConnection();
				$pdo_connection->beginTransaction();
				
				//update routing details
				$route->__set('route_id', $product->__get('route_id'));
				$route->__set('permalink', $this->replaceChars($_POST['permalink']));
				$route->update();
				
				//update product details
				$product->__set('product_title', $_POST['title']);
				$product->__set('description', $_POST['intro']);
				$product->__set('product_price', $_POST['product_price']);
				$product->update();
				
				//update tags
// 				$orig_tags	= $product_tags->__get('array_of_tags');
// 				$tags		= explode(',', str_replace(', ',',', $_POST['tags']));
// 				$remain_tags = array();
				
				//update images
				$this->handleImages($product_id, 'gallery_image_id');
				
// 				foreach($orig_tags as $tag)
// 					if(!in_array($tag, $tags))
// 						product_tag::delete($product_id, $tag);
// 					else
// 						$remain_tags[] = $tag;
					
// 				foreach($tags as $tag)
// 					if(!in_array($tag, $remain_tags))
// 						product_tag::insert($product_id, trim($tag));
			
			$pdo_connection->commit();
				header('Location: /products/product/edit/'.$product_id);
			}
			
			else
			{
// 				$tags = implode(', ', $product_tags->__get('array_of_tags'));
				$product_images = product_images::selectThumbnailByType($product_id);
				
				$view = new productView();
// 				$view->_set('tags', $tags);
				$view->_set('product', $product);
				$view->_set('product_images', $product_images);
				$view->displayProductEditor();
			}
		}
		
		else
		{
			$view = new productView();
			//$view->_set('tags', new product_tags());
			$view->_set('product', new product());
			$view->displayProductEditor();
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function deleteAction()
	{	
		$product_id = $this->getValueOfURLParameterPair('delete');
		
		if(is_numeric($product_id))
		{
			//start SQL transaction
			/* NOTE: SQL transactions should be used when a combination of insert, update
			 * and delete commands is executed
			 */
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
				
			$route			= new route();
			$product		= new product();
			
			$product->__set('product_id', $product_id);
			$product->select();
			
			//delete routing details
			$route->__set('route_id', $product->__get('route_id'));
			$route->delete();
			
			//delete product details
			product::delete($product_id);
			
			$pdo_connection->commit();
		}
		
		header('Location: /products');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	private function replaceChars($permalink)
	{
		$characters = array(' ','_',',','\'','.',':',';','?','!');
		
		$string = strtolower(str_replace($characters, '-', $permalink));
		
		return trim($string, '-');
	}
	
//-------------------------------------------------------------------------------------------------	
	
	private function handleImages($product_id, $post_key)
	{
		if(isset($_POST[$post_key]))
		{
			$i = 0;
			
			//delete
			foreach(product_images::selectProductImageIDs($product_id) as $id)
				if(!in_array($id, $_POST[$post_key]))
					if($id != 0 )product_image::delete($id);
			
			foreach($_POST[$post_key] as $value)
			{
				if($_POST['image_id'][$i] != '' || $_POST['image_id'][$i] != NULL)
				{
					$product_image	= new product_image();
					$product_image->__set('product_id', $product_id);
					$product_image->__set('image_id', $_POST['image_id'][$i]);
					$product_image->__set('used_for', 'gallery');
					
					//add
					if($value == 0)
						$product_image->insert();
					
					//update
					else
					{
						$product_image->__set('product_image_id', $value);
						$product_image->update();
					}
				}
				$i++;
			}
		}
		else
			product_images::deleteByProductID($product_id);
	}
}


