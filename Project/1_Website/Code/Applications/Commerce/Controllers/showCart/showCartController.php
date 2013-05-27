<?php
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'showCartView.php';

class showCartController extends applicationsSuperController
{
	public function indexAction()
	{ 
		$cart = '';
		
		$shoppingCartSession = new Zend_Session_Namespace('cart');
		$shoppingCart = $shoppingCartSession->__get('cart');
		//echo "<pre>";var_dump($shoppingCart->items[0]->quantity);die;
		if($shoppingCart == NULL) {
			die('shopping cart is empty');
		} else { 
			require_once 'Project/Model/Photo_Library/image/image.php';
			$showCartView = new showCartView();
			$showCartView->_set('shopping_cart', $shoppingCart);
			$showCartView->displayShoppingCart();			
		}
	}
}