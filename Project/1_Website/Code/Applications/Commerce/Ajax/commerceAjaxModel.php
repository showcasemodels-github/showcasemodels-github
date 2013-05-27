<?php
require_once 'Project/1_Website/Code/Applications/Products/Controllers/products/productsModel.php';

class commerceAjaxModel 
{
	//used by shopping cart controller line 56!
	public function getProductDetails($product_id)
	{	
		$product = new productsModel(); 
		$product->__set('product_id', $product_id);
		$product->selectProduct();
	
		return $product;
	}
	
	
}
?>