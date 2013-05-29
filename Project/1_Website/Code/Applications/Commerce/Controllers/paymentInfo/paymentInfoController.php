<?php 
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'paymentInfoView.php';

class paymentInfoController extends applicationsSuperController {
	
	public function indexAction() 
	{
		$shipping_cost;
		
		if(isset($_POST['proceedToPaymentInfo'])) 
		{ 
			if($_POST['ShippingMethod'] == "Free Shipping") :
				$shipping_cost = 0;
			elseif ($_POST['ShippingMethod'] == "UPS Ground") :
				$shipping_cost = 18;
			elseif ($_POST['ShippingMethod'] == "UPS Hawaii / Canada / Alaska / Outside Continental US") :
				$shipping_cost = 45;
			elseif ($_POST['ShippingMethod'] == "USPS Priority Mail") :
				$shipping_cost = 65;
			elseif ($_POST['ShippingMethod'] == "UPS 2nd Day Air") :
				$shipping_cost = 70;
			elseif ($_POST['ShippingMethod'] == "UPS 3 Day Select") :
				$shipping_cost = 35;
			endif;		
			
			$shoppingCartController = new shoppingCartController();
			$shoppingCart = $shoppingCartController->getShoppingCart();
			//shipping payment view
			$paymentInfoView = new paymentInfoView();
			$paymentInfoView->_set('shoppingCart', $shoppingCart);
			$paymentInfoView->_set('shipFullName', $_POST['name']);
			$paymentInfoView->_set('shipEmail', $_POST['shipEmail']);
			$paymentInfoView->_set('shipPhone', $_POST['shipPhone']);
			$paymentInfoView->_set('shipFax', $_POST['shipFax']);
			$paymentInfoView->_set('shipCompany', $_POST['shipCompany']);
			$paymentInfoView->_set('shipAddress', $_POST['shipAddress']);
			//bill
			$paymentInfoView->_set('billFullName', $_POST['name']);
			$paymentInfoView->_set('billEmail', $_POST['billEmail']);
			$paymentInfoView->_set('billPhone', $_POST['billPhone']);
			$paymentInfoView->_set('billFax', $_POST['billFax']);
			$paymentInfoView->_set('billCompany', $_POST['billCompany']);
			$paymentInfoView->_set('billAddress', $_POST['billAddress']);
			$paymentInfoView->_set('shippingCost', number_format($shipping_cost,2));
			$paymentInfoView->_set('shipping_method', $_POST['ShippingMethod']);
			$paymentInfoView->_set('payment_method', $_POST['PaymentMethod']);
			$paymentInfoView->displayPaymentSelection();
		} 
		else 
		{
			$paymentInfoView = new paymentInfoView();
			$paymentInfoView->displayPaymentSelection();
		}
	}
	
}
?>