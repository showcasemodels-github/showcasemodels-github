<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class profileView extends applicationsSuperView
{
	private $shiptoFirstname;
	private $shiptoLastname;
	private $shiptoAddress;
	private $shiptoAddress_2;
	private $shiptoCity;
	private $shiptoState;
	private $shiptoZipcode;
	private $shiptoCountry;
	private $shiptoPhone;
	private $shiptoOther_state;
	private $shiptoFax;
	private $shiptoCompany;
	
	private $billtoFirstname;
	private $billtoLastname;
	private $billtoAddress;
	private $billtoAddress_2;
	private $billtoCity;
	private $billtoState;
	private $billtoZipcode;
	private $billtoCountry;
	private $billtoPhone;
	private $billtoOther_state;
	private $billtoFax;
	private $billtoCompany;
	
	private $edit_shiptoState;
	private $edit_shiptoCountry;
	private $edit_billtoState;
	private $edit_billtoCountry;

	public function _set($field, $value) {
		if(property_exists($this, $field)) $this->{$field} = $value;
	}	
	
	public function _get($input)
	{
		return $this->$input;
	}
	
	public function showProfileForm()
	{ 
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/User_Account/accounts/templates/profile_form.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('login css'=>$content));
	
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/js_links.phtml');
		response::getInstance()->addContentToStack('global_javascript_bottom',array('login js'=>$content));
	}
	
}
