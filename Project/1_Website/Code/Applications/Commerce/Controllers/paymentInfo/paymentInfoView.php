<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class paymentInfoView extends applicationsSuperView
{
	private $shoppingCart;
	//shipping address variables
	private $shipFullName;
	private $shipEmail;
	private $shipPhone;
	private $shipFax;
	private $shipCompany;
	private $shipAddress;
	private $shippingCost;
	private $billFullName;
	private $billEmail;
	private $billPhone;
	private $billFax;
	private $billCompany;
	private $billAddress;
	
	private $shipping_method;
	private $payment_method;
	
	//different variables for bill to address
	
	public function _get($field) {
		if(property_exists($this, $field)) return $this->{$field}; 
		else return NULL;
	}
		
	public function _set($field, $value) {
		if(property_exists($this, $field)) $this-> { $field } = $value;
	}
		
	//display shipping payment selection as guest
	public function displayPaymentSelection()
	{
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Controllers/paymentInfo/paymentInfo.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}
	
}