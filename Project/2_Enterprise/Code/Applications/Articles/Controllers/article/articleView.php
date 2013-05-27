<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';
require_once 'Project/Model/Articles/article_images.php';

class articleView extends applicationsSuperView
{
	private $templates_location;

	private $article;
	private $article_images;
	private $article_elements;
	private $tags;
	
	//default for photo library
	private $album_id;
	private $size_id;
	
	public function __construct()
	{
		$this->templates_location = 'Project/2_Enterprise/Design/Applications/Articles/Controllers/templates/articles/';
	}
	
//-------------------------------------------------------------------------------------------------	

	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function _set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------

	public function displayArticleEditor()
	{
		$content = $content = $this->renderTemplate($this->templates_location.'article_editor.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'article_sidebar.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_SIDEBAR'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'delete_article_dialog.phtml');
		response::getInstance()->addContentToTree(array('DELETE_ARTICLE_DIALOG'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'elements_default_template.phtml');
		response::getInstance()->addContentToTree(array('ELEMENTS_DEFAULT_TEMPLATE'=>$content));
	}
	
//-------------------------------------------------------------------------------------------------

	public function displayAddArticleDialog()
	{	
		$content = $this->renderTemplate($this->templates_location.'add_article_dialog.phtml');
		response::getInstance()->addContentToTree(array('ADD_ARTICLE_DIALOG'=>$content));
	}
}
?>