<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'orderDetailsView.php';

class orderDetailsController extends applicationsSuperController
{
	public function indexAction() {
		//express check out
		if(isset($_POST['expressCheckOut'])) {
			$this->guestExpressCheckOut();
		} else {
			//if user forces url location to this page without logging in redirect user to homepage
			if(!authorization::areWeLoggedIn()) {
				header('Location: /');
			} else { 
				$this->registeredExpressCheckOut();
			}			
			
		}
	}
	
	public function guestExpressCheckOut() {
		
		require_once 'Project/Model/Photo_Library/image/image.php';
		
		$shoppingCartController = new shoppingCartController();
		$shoppingCart = $shoppingCartController->getShoppingCart();	
		
		$orderDetailsView = new orderDetailsView();
		$orderDetailsView->_set('shopping_cart', $shoppingCart);
		$orderDetailsView->displayExpressCheckout();
	}
	//
	public function registeredExpressCheckOut() {
 		require_once 'Project/Model/UserAccount/userAccount.php';
 		require_once 'Project/Model/Photo_Library/image/image.php';
		
 		$userAccount = new userAccount();
		
//		fetch user info
 		$userAccount->__set('customer_id', authorization::getUserID());
 		$userAccount->select_user();
 		$data = $userAccount->__get('user_info');
		
 		$orderDetailsView = new orderDetailsView();
 		$orderDetailsView->_set('firstname', $data['firstname']);
 		$orderDetailsView->_set('lastname', $data['lastname']);
 		$orderDetailsView->_set('address', $data['address']);
 		$orderDetailsView->_set('address_2', $data['address_2']);
 		$orderDetailsView->_set('city', $data['city']);
 		$orderDetailsView->_set('state', $data['state']);
 		$orderDetailsView->_set('zipcode', $data['zipcode']);
 		$orderDetailsView->_set('country', $data['country']);
 		$orderDetailsView->_set('phone', $data['phonenumber']);
 		$orderDetailsView->_set('fax', $data['faxnumber']);
 		$orderDetailsView->_set('company', $data['company']);
 		$orderDetailsView->_set('email', $data['email']);
 		
 		$shoppingCartController = new shoppingCartController();
 		$shoppingCart = $shoppingCartController->getShoppingCart();
 		
 		$orderDetailsView->_set('shopping_cart', $shoppingCart);

		$orderDetailsView->displayRegisteredCheckOut();
		
	}
}