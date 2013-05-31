<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class categoryView extends applicationsSuperView
{
	
//-------------------------------------------------------------------------------------------------	

	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}

	public function _set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
 	public function displayMainLayout()
	{
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Category_Manager/Controllers/tremplates/category/category_listing.phtml");
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}
	
	public function displayCategoryEditor()
	{
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Category_Manager/Controllers/tremplates/category/category_editor.phtml");
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}

	public function displaySubcategoryEditor()
	{
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Category_Manager/Controllers/tremplates/category/subcategory_editor.phtml");
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}
	
}
?>