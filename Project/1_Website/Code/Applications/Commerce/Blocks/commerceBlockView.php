<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

//----------------------------------------------------------

class commerceBlockView extends applicationsSuperView
{
	//===============================================================================================================================
	 public function shoppingCartControlPanel()
	 {
	 	return "My Wish List (22 items)|

	 	 
	 	 <a href='/eshop/cart'>My Shopping Bag (9 items)</a> | <a href='/eshop/delivery'>Proceed to Checkout</a>
	 	<div id='shopping_basket'></div>
	 	";
	 }
	 
	 //===============================================================================================================================
	 
	 public function addToShoppingCartLink($product)
	 {
	 	$content = $this->renderTemplate('Project/Design/'.DOMAIN.'/Applications/Commerce/Blocks/add_to_cart.js');
	 	response::getInstance()->addContentToStack('inpage_javascript_top',array('ADDTO_SHOPPPING_CART_JAVASCRIPT_INPAGE'=>$content));
	 		
	 	//foreach($products->getArrayOfProducts() as $product)
	 	//{
	 		$content = 'product';
	 		$content .= '<input type="submit" product_id="'.$product->getProductPaymentID().'" value="add to cart" title="pee" id="addToCart" style="cursor:pointer;">';
		 	$contentArray[] = $content;
	 	//};
	 	
	 	return $content;
	 }
	 
	 //===============================================================================================================================
	 public function shoppingCartDropDownBoxHolder()
	 {
		$content = '<div id="shoppingCartDropDown"></div>';
	 	return $content;
	 }
	 
}