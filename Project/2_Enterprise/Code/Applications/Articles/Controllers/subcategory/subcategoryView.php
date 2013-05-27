<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class subcategoryView extends applicationsSuperView
{
	private $templates_location;
	
	private $subcategory;
	
	//default for photo library
	private $album_id;
	private $size_id;
	
	public function __construct()
	{
		$this->templates_location = 'Project/2_Enterprise/Design/Applications/Articles/Controllers/templates/subcategories/';
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

	public function displaySubCategoryEditor()
	{
		$content = $content = $this->renderTemplate($this->templates_location.'subcategory_editor.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'subcategory_sidebar.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_SIDEBAR'=>$content));
		
		$content = $this->renderTemplate($this->templates_location.'delete_subcategory_dialog.phtml');
		response::getInstance()->addContentToTree(array('DELETE_SUBCATEGORY_DIALOG'=>$content));
	}
	
//-------------------------------------------------------------------------------------------------

	public function displayAddSubCategoryDialog()
	{	
		$content = $this->renderTemplate($this->templates_location.'add_subcategory_dialog.phtml');
		response::getInstance()->addContentToTree(array('ADD_SUBCATEGORY_DIALOG'=>$content));
	}
}
?>