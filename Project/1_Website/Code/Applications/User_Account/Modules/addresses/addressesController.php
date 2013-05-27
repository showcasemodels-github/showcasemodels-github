<?php
require_once 'Zend/Session.php';

require_once 'Project/Code/System/Accounts/addresses/address.php';


class addressesController 
{
	 //===============================================================================================================================
	 public function getBillingAddress($user_id) 
	 {
		$address = new address();
		$address->getBillingAddress($user_id);
		return $address;
	 }
	 //===============================================================================================================================
	 public function getDeliveryAddress($user_id)
	 {
	 	$address = new address();
	 	$address->getDeliveryAddress($user_id);
	 	return $address;
	 }
	 
	 public function setDeliveryAddress($user_id, $new_address)
	 {
	 	$address = new address();
	 	$address->setDeliveryAddress($user_id, $new_address);
	 }
	 
	 
}

?>