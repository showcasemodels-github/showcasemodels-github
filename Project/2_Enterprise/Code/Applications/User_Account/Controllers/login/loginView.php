<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class loginView extends applicationsSuperView
{
	private $login_error;
	
	public function getLoginError() { return $this->login_error; }
	
	public function showLoginForm($login_error = FALSE)
	{
		$this->login_error = $login_error;
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/User_Account/Main_App_Layout/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('LOGIN_CSS'=>$content));
		
        $content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/User_Account/Main_App_Layout/templates/inpage_javascript.js');
        response::getInstance()->addContentToStack('local_javascript_top',array('LOGIN SCRIPT'=>$content));
        
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/User_Account/Blocks/login_form.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
	
}