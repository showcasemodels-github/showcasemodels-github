<?php

require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/Model/UserAccount/userAccount.php';
require_once 'welcomeView.php';


class welcomeController extends applicationsSuperController
{
	public function indexAction()
	{
		$basePath  = request::getInstance()->getPathInfo(); //Zend function
		
		if(!authorization::areWeLoggedIn())
		{
			/* require_once 'Project/Code/1_Website/Applications/User_Account/Controllers/login/loginController.php';
			$loginController = new loginController();
			$loginController->indexAction(); */
		
			if (isset($_POST['login']))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				$user_account = new userAccount();
				$user_account->setUserName($username);
				$user_account->setPassword(sha1(md5($password)));
				$user_account->select_login();
				$user_account->getUserAccountID();
				
				if (is_numeric($user_account->getUserAccountID()))
				{
					//for chat functionality ??
					//$user_account->update_online_status(1);
					
					$user_account->getUserRoleID();
					authorization::saveUserSession($user_account);
					
					if (applicationsRoutes::getInstance()->getCurrentControllerID() !='login')
						//if the user was redirected to the login page - send him back from the page he came from
						header('Location: '.$basePath);
					else
						//if the user is on the login page by his own will - send him to the home page and not back to the login page	
						header('Location:/');
				}
				else 
				{
					$login_error = TRUE;
					$view = new welcomeView();
					$view->displayLoginExpressCheckoutForm($login_error);
				}
			}
				
			else
			{
				$login_error = FALSE;
				$view = new welcomeView();
				$view->displayLoginExpressCheckoutForm($login_error);
			}
				
		}
		else
			header('Location: /shop/order-details');
	}
}