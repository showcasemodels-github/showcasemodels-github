<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class welcomeView extends applicationsSuperView
{
	private $login_error;
	
	public function getLoginError()
	{
		return $this->login_error;
	}
		
	public function displayLoginExpressCheckoutForm($login_error)
	{
		$this->login_error = $login_error;
		//$currentApplicationID = applicationsRoutes::getInstance()->getCurrentApplicationID();
		
		//$content = $this->renderTemplate('Project/Design/'.DOMAIN.'/Applications/'.$currentApplicationID.'/Main_App_Layout/templates/js_and_css_links.phtml');
		//response::getInstance()->addContentToStack('css_and_javascript_links_for_this_page_only',array('COMMERCE_CS_JS'=>$content));

		//$content = $this->renderTemplate('Project/Design/'.DOMAIN.'/Applications/'.$currentApplicationID.'/Main_App_Layout/templates/main_app_layout.phtml');
		//response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
		$content = $this->renderTemplate('Project/1_Website/Design/Applications/Commerce/Controllers/welcome/welcome.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_CONTENT'=>$content));
	}

}