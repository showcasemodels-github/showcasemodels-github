<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class searchView extends applicationsSuperView
{
	private $array_of_products;
	//-------------------------------------------------------------------------------------------------
	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
	
		else return NULL;
	}
	//-------------------------------------------------------------------------------------------------
	public function _set($field, $value) {
		if(property_exists($this, $field)) $this->{$field} = $value;
	}
	//-------------------------------------------------------------------------------------------------
	
	public function displayMainLayout()
	{ 
		require_once 'Project/Model/Products/product_image.php';
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Search/Controllers/templates/main_template.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Search/Controllers/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('product search css'=>$content));
	}
}
?>