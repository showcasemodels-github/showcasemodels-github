<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';

require_once 'Project/Model/UserAccount/userAccount.php';
require_once 'forgot_passwordView.php';


class forgot_passwordController extends applicationsSuperController
{
	
	public function indexAction()
	{
		$forgot_passwordView = new forgot_passwordView();
		$forgot_passwordView->showForgotPasswordForm();

	}
}
?>