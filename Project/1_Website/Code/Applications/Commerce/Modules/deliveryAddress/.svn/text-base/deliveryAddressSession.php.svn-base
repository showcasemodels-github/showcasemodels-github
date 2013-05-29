<?php
require_once 'Zend/Session.php';
//require_once 'Project/Code/System/Accounts/addresses/address.php';

class deliveryAddressSession
{	 
	public function saveDeliveryAddressSession($address) 
	 {
	 	$deliveryAddressSession = new Zend_Session_Namespace('delivery_address');
	 	$deliveryAddressSession->__set('delivery_address',$address);
	 	$deliveryAddressSession->deliveryAddressExists = TRUE;
	 }
	 
//===============================================================================================================================

	 private function doesDeliveryAddressSessionExist()
	 {
	 	Zend_Session::rememberMe();
	 	
	 	$deliveryAddressSession = new Zend_Session_Namespace('delivery_address');
	 	
	 	if ($deliveryAddressSession->deliveryAddressExists == TRUE)
	 		return TRUE;

	 	else
	 		return FALSE;
	 }
	 
//===============================================================================================================================

	 public function getDeliveryAddress()
	 {
	 	if ($this->doesDeliveryAddressSessionExist() == TRUE)
	 	{
	 		$deliveryAddressSession = new Zend_Session_Namespace('delivery_address');
	 		$delivery_address = $deliveryAddressSession->__get('delivery_address');
	 		$delivery_address = unserialize(serialize($delivery_address)); //only needed if you use objects
	 	}
	 	
	 	else
	 		$delivery_address =  new address();
	 
	 	return $delivery_address;
	 }

	 
}

?>