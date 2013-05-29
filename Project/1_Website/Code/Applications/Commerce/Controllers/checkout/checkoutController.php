<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'Project/Model/UserAccount/userAccount.php';
require_once 'checkoutView.php';
require_once 'checkoutModel.php';


class checkoutController extends applicationsSuperController
{ 
	public function __construct()
	{
		parent::__construct();
		if(shoppingCartController::doesShoppingCartSessionExist() == FALSE)
		header('Location: /shop/cart');
	}
	
	public function indexAction()
	{
		$product_id = '';
		$product_title = '';
		$product_quantity = '';
		$product_price = '';
				
		if(!authorization::areWeLoggedIn())  {
			//express checkout not login
			header('Location: /shop/welcome');
		} 
		else
		{
			if(isset($_POST['tocheckout']))
 			{
				$array_of_id = $_POST['product_id'];
				$array_of_title = $_POST['title'];
				$array_of_quantity = $_POST['quantity'];
				$array_of_price = $_POST['price'];
				$total = $_POST['total'];
				$limit = count($array_of_id);
					
				for($i = 0;$i != $limit ;$i++)
				{
					$product_id .= $array_of_id[$i].',';
					$product_title .= $array_of_title[$i].',';
					$product_quantity .= $array_of_quantity[$i].',';
					$product_price .= $array_of_price[$i].',';
				}
					
				$product_id = rtrim($product_id, ',');
				$product_title = rtrim($product_title, ',');
				$product_quantity = rtrim($product_quantity, ',');
				$product_price = rtrim($product_price, ',');
					
				$userAccount = new userAccount();
				$userAccount->setUserAccountID(authorization::getUserID());
				$userAccount->__set('product_id', $product_id);
				$userAccount->__set('product_title', $product_title);
				$userAccount->__set('product_quantities', $product_quantity);
				$userAccount->__set('product_prices', $product_price);
				$userAccount->__set('total_price', $total);
				//$userAccount->insertCheckout();
				
				header('Location: /shop/order-details');
 			}
 			else 
 			{
 				header('Location: /shop/cart');
 			}
		}
	}
}
