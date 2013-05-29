<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/1_Website/Code/Applications/Commerce/Modules/shoppingCart/shoppingCartController.php';
require_once 'shippingPaymentView.php';

class shippingPaymentController extends applicationsSuperController
{
	public function indexAction() {
		
		if(isset($_POST['proceedToShippingPayment'])) {
			$shoppingCartController = new shoppingCartController();
			$shoppingCart = $shoppingCartController->getShoppingCart();
				
			//shipping payment view
			$shippingPaymentView = new shippingPaymentView();
			$shippingPaymentView->_set('shoppingCart', $shoppingCart);
			$shippingPaymentView->_set('shipFullName', $_POST['ShipFirstName'].' '.$_POST['ShipLastName']);
			$shippingPaymentView->_set('shipEmail', $_POST['ShipEmail']);
			$shippingPaymentView->_set('shipPhone', $_POST['ShipPhone']);
			$shippingPaymentView->_set('shipFax', $_POST['ShipFax']);
			$shippingPaymentView->_set('shipCompany', $_POST['ShipCompany']);
				
			$shippingAddress = $_POST['ShipAddress1'];
			
			if (!empty($_POST['ShipAddress2'])) :
				',<br /> '.$_POST['ShipAddress2'];
			endif;
			
			$shippingAddress .= ',<br /> '.$_POST['ShipCity'].', '.$_POST['ShipZip'];
			$shippingPaymentView->_set('shipAddress', $shippingAddress);
			
			//bill
			$shippingPaymentView->_set('billFullName', $_POST['BillFirstName'].' '.$_POST['BillLastName']);
			$shippingPaymentView->_set('billEmail', $_POST['BillEmail']);
			$shippingPaymentView->_set('billPhone', $_POST['BillPhone']);
			$shippingPaymentView->_set('billFax', $_POST['BillFax']);
			$shippingPaymentView->_set('billCompany', $_POST['BillCompany']);
			
			$billingAddress = $_POST['BillAddress1'];
			
			if (!empty($_POST['BillAddress2'])) :
				',<br /> '.$_POST['BillAddress2'];
			endif;
			
			$billingAddress .= ',<br /> '.$_POST['BillCity'].', '.$_POST['BillZip'];
			$shippingPaymentView->_set('billAddress', $billingAddress);
			$shippingPaymentView->displayShippingPayment();
		} else {
			$shippingPaymentView = new shippingPaymentView();
			$shippingPaymentView->displayShippingPayment();
		}
	}
}