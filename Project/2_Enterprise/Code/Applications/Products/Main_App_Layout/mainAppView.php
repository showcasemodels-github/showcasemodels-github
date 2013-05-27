<?php
require_once(FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php');

class mainAppView extends viewSuperClass_Core
{
	private $current_application_ID;
	private $album_id;
	private $size_id;
	
	private $product_list;
	private $categories;
	private $subcategories;
	
	public function __construct()
	{
		$this->current_application_ID = applicationsRoutes::getInstance()->getCurrentApplicationID();
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

	public function displayMainApplicationLayout()
	{
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Products/Main_App_Layout/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('PRODUCTS_CS'=>$content));
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Products/Main_App_Layout/templates/inpage_javascript.js');
		response::getInstance()->addContentToStack('local_javascript_bottom',array('CURRENT SECTION CSS'=>$content));
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Products/Main_App_Layout/templates/main_app_layout.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
	
//-------------------------------------------------------------------------------------------------	

	public function displayProductsNavigation()
	{	
		require_once 'Project/2_Enterprise/Code/Applications/Products/Navigation/productsNavigation.php';
		
		$productsNavigation = new productsNavigation();
		$productsNavigation->init();
		$content = $productsNavigation->getNavigationListAsArray();
		//print $content; die;
		response::getInstance()->addContentToTree(array('APPLICATION_LEFT_COLUMN'=>$content));
	}
	
//-------------------------------------------------------------------------------------------------	

	public function displayPopUpDialogs()
	{
		require_once 'Project/2_Enterprise/Code/Applications/Products/Controllers/product/productView.php';
		require_once 'Project/2_Enterprise/Code/Applications/Products/Controllers/subcategory/subcategoryView.php';
		require_once 'Project/2_Enterprise/Code/Applications/Products/Controllers/category/categoryView.php';
		
		$productView		= new productView();
		$categoryView 		= new categoryView();
		$subcategoryView 	= new subcategoryView();
		
		//$productView->displayAddProductDialog();
		//$categoryView->displayAddCategoryDialog();
		//$subcategoryView->displayAddSubCategoryDialog();
	}
	
}
?>