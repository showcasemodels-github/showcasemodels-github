<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class productView extends applicationsSuperView
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
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Products_Manager/Controllers/templates/products/products_listing.phtml");
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}
	
	public function displayProductEditor()
	{
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Products_Manager/Controllers/templates/products/product_editor.phtml");
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
		
		//$this->displayDeleteDialog();
	}
	
	public function displayDeleteDialog()
	{
		$content = $this->renderTemplate("Project/2_Enterprise/Design/Applications/Products_Manager/Controllers/templates/products/delete_dialog.phtml");
		response::getInstance()->addContentToTree(array('dialogues'=>$content));
	}
}
?>