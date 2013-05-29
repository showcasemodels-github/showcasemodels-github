
<?php
require_once 'Zend/Session.php';
require_once 'shoppingCartObject/shoppingCart.php';
require_once 'shoppingCartObject/shoppingCartItem.php';

class shoppingCartController 
{
	
//===============================================================================================================================
	 
	public function saveShoppingCartSession($shoppingCart) 
	 {
	 	$shoppingCartSession = new Zend_Session_Namespace('cart');
	 	$shoppingCartSession->__set('cart',$shoppingCart);
	 	$shoppingCartSession->shoppingCartExists=true;
	 }
	 
//===============================================================================================================================

	 private function doesShoppingCartSessionExist()
	 { 
	 	Zend_Session::rememberMe(); 
	 	$shoppingCartSession = new Zend_Session_Namespace('cart'); 
	 	if ($shoppingCartSession->shoppingCartExists==true) {
	 		return true;
	 	}
	 	else { 
	 		return false; 
	 	}
	 }
	 
//===============================================================================================================================

	 public function getShoppingCart()
	 {
	 	if 	(true == $this->doesShoppingCartSessionExist())
	 	{
	 		$shoppingCartSession = new Zend_Session_Namespace('cart');
	 		$shoppingcart = $shoppingCartSession->__get('cart');  
	 		$shoppingcart = unserialize(serialize($shoppingcart)); //only needed if you use objects
	 	}
	 	else
	 	{
	 		$shoppingcart =  new shoppingCart();
	 	} 
	 	return $shoppingcart; 
	 }

	 
}

?>