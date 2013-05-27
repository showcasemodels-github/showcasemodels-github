<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';


class showCartView extends applicationsSuperView
{
	private $shopping_cart;
		
	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	public function _set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
	
	public function displayShoppingCart()
	{ 
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Main_App_Layout/templates/inpage_javascript.js');
		response::getInstance()->addContentToStack('local_javascript_top',array('java js'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Controllers/showCart/showCart.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
	}
	
}