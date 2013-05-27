<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'loginView.php';
require_once 'loginModel.php';


class loginController extends applicationsSuperController
{
	
	public function indexAction()
	{
		$loginView = new loginView();

		if (isset($_POST['login']))
		{
			$username = $_POST['username'];
			$password = sha1(md5($_POST['password']));

			$user_account = new loginModel();
			$user_account->__set('username', $username);
			$user_account->__set('password', $password);
			$user_account->login();
			$user_account->__get('user_account_id');

			if (is_numeric($user_account->__get('user_account_id')))
			{  
			authorization::saveUserSession($user_account);
			header('Location: /user/profile');
			}
			else
			{
				$login_error = TRUE;
				$loginView->showLoginForm($login_error);
			}
		}
		else
		{
			
			$loginView->showLoginForm();
		}
	}
	
	//AJAX CONFIRMATION etc
	
}