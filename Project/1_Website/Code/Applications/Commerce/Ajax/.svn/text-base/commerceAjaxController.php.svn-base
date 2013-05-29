
<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'Project/1_Website/Code/Panels/header/headerView.php';
require_once 'commerceAjaxModel.php';
require_once 'commerceAjaxView.php';

//----------------------------------------------------------

class commerceAjaxController extends applicationsSuperController
{
	 public function addProductToShoppingCartAction()
	 {
	 	
	 	//called from a Block
	 	//i just put in some hard coded details to see if shopping cart works

	 		$product_id = $_REQUEST['product_id'];
			$product_name = $_REQUEST['product_name'];
			$quantity = $_REQUEST['quantity'];
			$price = $_REQUEST['pricing'];

	 		$shoppingCartItem = new shoppingCartItem($product_id);
	 		$shoppingCartItem->setQuantity($quantity);
	 		$shoppingCartItem->price= $price;
	 		$shoppingCartItem->product_name = $product_name;
	 		
	 		$shoppingCartController = new shoppingCartController(); 
	 		
	 		$shoppingCart = $shoppingCartController->getShoppingCart();
	 		$shoppingCart->addItem($shoppingCartItem);
	 		
	 		$shoppingCartController->saveShoppingCartSession($shoppingCart); 
	 		jQuery::getResponse();
			
	 	}
	 	
	 	public function changeItemQuantityAction()
	 	{
	 		//called from showCart
	 		 
	 		$product_id = $_GET['product_id'];
	 		$quantity = $_GET['quantity'];
	 		 
	 		$shoppingCartController = new shoppingCartController();
	 		$shoppingCart = $shoppingCartController->getShoppingCart();
	 		$shoppingCart->changeQuantity($product_id,$quantity);
	 		
	 		
	 		if ($quantity == 0) {
	 			$shoppingCart->deleteItem($product_id);
	 		}
	 		 
	 		//The shopping cart Icon total
	 		$shoppingCartController->saveShoppingCartSession($shoppingCart);
	 		$numberOfItems = $shoppingCart->getNumberOfItems(true);
	 		
	 		jQuery('span#numberOfItems')->html($numberOfItems);
	 		 
	 		$totalPrice = $shoppingCart->getTotalPrice();
	 		jQuery('#totalPrice')->html($totalPrice);
	 		jQuery::getResponse();
	 	
	 	}
	 	
	 	public function removeProductFromShoppingCartAction()
	 	{
	 		//called from showCart
	 		 
	 		$product_id = $_GET['product_id'];
	 		
	 		$shoppingCartController = new shoppingCartController();
	 		$shoppingCart = $shoppingCartController->getShoppingCart();
	 		$shoppingCart->deleteItem($product_id);
	 		 
	 		$totalPrice = $shoppingCart->getTotalPrice();
	 		jQuery('#totalPrice')->html($totalPrice);
	 		$numberOfItems = $shoppingCart->getNumberOfItems(true);
	 		jQuery('span#numberOfItems')->html($numberOfItems);
	 		 
	 		$shoppingCartController->saveShoppingCartSession($shoppingCart);
	 		jQuery::getResponse();
	 	
	 	}
	 	
	 	public function fetchNumberOfItemsAction()
	 	{
	 		$cart = '';
	 		$quantity = 0;
	 		$headerView = new headerView();
	 		$shoppingCartSession = new Zend_Session_Namespace('cart');
	 		$shoppingCart = $shoppingCartSession->__get('cart');
	 		
	 		if($shoppingCart != NULL) 
		 		{
		 		foreach($shoppingCart->items as $items)
		 		{
		 			$quantity += $items->quantity;
		 		}
		 		
		 		require_once 'Project/Model/Photo_Library/image/image.php';
		 		jQuery('span.cartItemQuantity')->html($quantity);
	 		}
	 		else 
	 		{
	 			jQuery('span.cartItemQuantity')->html(0);
	 		}
	 		jQuery::getResponse();
	 	}
	 
	 
	 //===============================================================================================================================
	
	 
}
