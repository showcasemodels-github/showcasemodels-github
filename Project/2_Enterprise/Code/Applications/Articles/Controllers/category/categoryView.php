<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class categoryView extends applicationsSuperView
{
	private $templates_location;

	private $category;
	
	public function __construct()
	{
		$this->templates_location = 'Project/2_Enterprise/Design/Applications/Articles/Controllers/templates/categories/';
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

	public function displayCategoryEditor()
	{
		$content = $content = $this->renderTemplate($this->templates_location.'category_editor.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'category_sidebar.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_SIDEBAR'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'delete_category_dialog.phtml');
		response::getInstance()->addContentToTree(array('DELETE_CATEGORY_DIALOG'=>$content));
	}
	
//-------------------------------------------------------------------------------------------------

	public function displayAddCategoryDialog()
	{	
		$content = $this->renderTemplate($this->templates_location.'add_category_dialog.phtml');
		response::getInstance()->addContentToTree(array('ADD_CATEGORY_DIALOG'=>$content));
	}
}
?>