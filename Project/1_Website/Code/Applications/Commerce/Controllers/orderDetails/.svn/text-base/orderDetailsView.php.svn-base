<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class orderDetailsView extends applicationsSuperView
{
	private $shopping_cart;
	private $unfinished_transactions;
	private $array_of_product_id;
	private $array_of_product_titles;
	private $array_of_product_quantities;
	private $array_of_product_prices;
	private $array_of_total_price;
	private $array_of_number_of_products;
	
	private $firstname;
	private $lastname;
	private $address;
	private $address_2;
	private $city;
	private $state;
	private $zipcode;
	private $country;
	private $phone;
	private $fax;
	private $company;
	private $email;
	
	public function _get($field) {
		if(property_exists($this, $field)) return $this->{$field}; 
		else return NULL;
	}
		
	public function _set($field, $value) {
		if(property_exists($this, $field)) $this-> { $field } = $value;
	}
		
	//display express check out page
	public function displayExpressCheckout()
	{
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Controllers/orderDetails/expressCheckOut.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}
	//display check out for registered user
	public function displayRegisteredCheckOut()
	{
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Controllers/orderDetails/registeredCheckOut.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}

}