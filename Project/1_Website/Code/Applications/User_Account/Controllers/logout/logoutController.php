<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/Model/UserAccount/userAccount.php';


class logoutController extends applicationsSuperController
{
	public function indexAction()
	{
		authorization::unsetUserSession();
		header('Location: /');
	}
	
	
}