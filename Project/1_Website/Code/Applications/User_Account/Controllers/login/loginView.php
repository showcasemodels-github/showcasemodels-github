<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class loginView extends applicationsSuperView
{
	private $login_error;
	
	public function getLoginError()
	{
		return $this->login_error;
	}
	
	public function showLoginForm($login_error = FALSE)
	{   
		$this->login_error = $login_error;

		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/User_Account/accounts/templates/login_form.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('login css'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/User_Account/accounts/templates/js_links.phtml');
		response::getInstance()->addContentToStack('global_javascript_bottom',array('login js'=>$content));
	}
}