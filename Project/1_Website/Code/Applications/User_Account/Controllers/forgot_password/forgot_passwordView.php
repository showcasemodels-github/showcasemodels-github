<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class forgot_passwordView extends applicationsSuperView
{
	public function showForgotPasswordForm()
	{   
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/User_Account/accounts/templates/forgot_password_form.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
}