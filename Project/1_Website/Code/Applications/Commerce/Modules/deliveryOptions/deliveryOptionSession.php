<?php
require_once 'Zend/Session.php';

class deliveryOptionSession
{	 
	public function saveDeliveryOptionSession($delivery_option) 
	 {
	 	$deliveryOptionSession = new Zend_Session_Namespace('delivery_option');
	 	$deliveryOptionSession->__set('delivery_option',$option);
	 	$deliveryOptionSession->deliveryoptionExists = TRUE;
	 }
	 
//===============================================================================================================================

	 private function doesDeliveryOptionSessionExist()
	 {
	 	Zend_Session::rememberMe();
	 	
	 	$deliveryOptionSession = new Zend_Session_Namespace('delivery_option');
	 	
	 	if ($deliveryOptionSession->deliveryOptionExists == TRUE)
	 		return TRUE;

	 	else
	 		return FALSE;
	 }
	 
//===============================================================================================================================

	 public function getDeliveryOption()
	 {
	 	if ($this->doesDeliveryOptionSessionExist() == TRUE)
	 	{
	 		$deliveryOptionSession = new Zend_Session_Namespace('delivery_option');
	 		$delivery_option = $deliveryOptionSession->__get('delivery_option');
	 	}
	 	
	 	else
	 		$delivery_option =  NULL;
	 
	 	return $delivery_option;
	 }

	 
}

?>