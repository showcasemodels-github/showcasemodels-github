<?php
require_once 'Zend/Session.php';
//require_once 'Project/Code/System/Accounts/addresses/address.php';

class billingAddressSession
{	 
	public function saveBillingAddressSession($address) 
	 {
	 	$billingAddressSession = new Zend_Session_Namespace('billing_address');
	 	$billingAddressSession->__set('billing_address',$address);
	 	$billingAddressSession->billingAddressExists = TRUE;
	 }
	 
//===============================================================================================================================

	 private function doesBillingAddressSessionExist()
	 {
	 	Zend_Session::rememberMe();
	 	
	 	$billingAddressSession = new Zend_Session_Namespace('billing_address');
	 	
	 	if ($billingAddressSession->billingAddressExists == TRUE)
	 		return TRUE;

	 	else
	 		return FALSE;
	 }
	 
//===============================================================================================================================

	 public function getBillingAddress()
	 {
	 	if ($this->doesBillingAddressSessionExist() == TRUE)
	 	{
	 		$billingAddressSession = new Zend_Session_Namespace('billing_address');
	 		$billing_address = $billingAddressSession->__get('billing_address');
	 		$billing_address = unserialize(serialize($billing_address)); //only needed if you use objects
	 	}
	 	
	 	else
	 		$billing_address =  new address();
	 
	 	return $billing_address;
	 }

	 
}

?>