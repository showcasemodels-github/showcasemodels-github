<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/Model/Products/products.php';
require_once 'searchView.php';

class searchController extends applicationsSuperController
{
	public function indexAction()
	{
		$keyword = $_POST['search'];
		
		$products = new products();
		$products->searchProducts($keyword, FALSE);
		
		$searchView = new searchView(); 
		$searchView->_set('array_of_products', $products->__get('array_of_products'));
		$searchView->displayMainLayout();
	}
}
?>