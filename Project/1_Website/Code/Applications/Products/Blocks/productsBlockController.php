<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'productsBlockModel.php';
require_once 'productsBlockView.php';
require_once 'Project/Model/Products/products.php';

//----------------------------------------------------------

class productsBlockController 
{
	public function productsNavigation() 
	{
		$listOfSubcategories = array();
		
		$categories = new productsBlockModel();
		$categories->selectCategories();
		$listOfCategories = $categories->__get('array_of_categories');
		$numberOfCategories = count($categories->__get('array_of_categories'));

		for($i = 0;$i < $numberOfCategories;$i++)
		{
			$categories->__set('category_id', $listOfCategories[$i]['category_id']);
			$categories->selectCategoriesWithParent();
			$listOfSubcategories[] = $categories->__get('array_of_subcategories');
		}
		$productsBlockView = new productsBlockView(); 
		$productsBlockView->_set('array_of_subcategories', $listOfSubcategories);
		$productsBlockView->_set('array_of_categories', $categories->__get('array_of_categories'));
		$productsBlockView->displayProductNavigation();
	}
	
	
	public function displayFeaturedProducts()
	{
		$products = new productsBlockModel();
		$products->selectFeaturedProducts();
		$listOfProducts = $products->__get('array_of_products');
		$productsBlockView = new productsBlockView(TRUE); 
		$productsBlockView->_set('array_of_products', $listOfProducts);
		$test = $productsBlockView->displayFeaturedProducts();
		print $test;
	}
}