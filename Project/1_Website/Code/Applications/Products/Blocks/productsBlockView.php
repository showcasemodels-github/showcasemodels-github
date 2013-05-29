<?php 
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php'; 

class productsBlockView extends applicationsSuperView
{
	private $array_of_categories = array();
	private $array_of_products = array();
	private $array_of_subcategories = array();
	
	public function _get($field) {
		if(property_exists($this, $field)) return $this->{$field}; else return NULL;
	}
	public function _set($field, $value) {
		if(property_exists($this, $field)) $this->{$field} = $value;
	}
	
	public function displayProductNavigation() {
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Blocks/productsNavigation.phtml');
		response::getInstance()->addContentToTree(array('PRODUCTS_NAVIGATION'=>$content));
	}
	
	public function displayFeaturedProducts() { 
		return $content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Blocks/featured_products.phtml');
	}
}

?>