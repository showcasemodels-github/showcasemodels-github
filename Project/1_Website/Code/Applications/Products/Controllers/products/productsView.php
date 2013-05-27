<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class productsView extends applicationsSuperView
{
	private $product;
	private $array_of_random_products = array();
	private $array_of_products = array();
	private $array_of_subcategories = array();
	private $product_name;
	
//-------------------------------------------------------------------------------------------------	
	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	public function _set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//category
	public function displayProductByCategory()
	{	
		require_once 'Project/Model/Products/product_image.php';
		
		$this->cssJsLink();
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Controllers/templates/products_listing_category.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
//sub category	
	public function displayProductBySubCategory()
	{
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Controllers/templates/products_listing_subcategory.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	
		$this->cssJsLink();
	}
//display product details
	public function displayProductDetails()
	{ 
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Controllers/templates/product_details.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
		$this->cssJsLink();
	}
	
	public function cssJsLink()
	{
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Controllers/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('product css'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Products/Controllers/templates/js_links.phtml');
		response::getInstance()->addContentToStack('global_javascript_bottom',array('product js'=>$content));
	}	
}