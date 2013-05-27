<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class registrationView extends applicationsSuperView
{
	private $shiptoState;
	private $shiptoCountry;
	private $billtoState;
	private $billtoCountry;
	
	public function _set($field, $value) {
		if(property_exists($this, $field)) $this->{$field} = $value;
	}
	
	public function _get($input)
	{
		return $this->$input;
	}
	
	public function showRegistrationForm()
	{
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/User_Account/accounts/templates/registration_form.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('login css'=>$content));
	
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/js_links.phtml');
		response::getInstance()->addContentToStack('global_javascript_bottom',array('login js'=>$content));
	}
	
}
