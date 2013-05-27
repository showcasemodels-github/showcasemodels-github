<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'loginView.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
require_once 'Project/Model/Settings/settings.php';
require_once 'Project/Model/UserAccount/userAccount.php';

class loginController extends applicationsSuperController {	public function indexAction() {		$basePath  = request::getInstance()->getPathInfo(); 		//Zend function//
		if(isset($_POST['login'])) {			//$password = sha1(md5($_POST['password']));			$username = $_POST['username'];			$password = $_POST['password'];			
			if(settings::loginDummy($username, $password) == TRUE) {				$user_account = new userAccount();				$user_account->__set('username', $username);								//$user_account->setUserAccountID(1);				//$user_account->setUserRoleID('admin');								authorization::saveUserSession($user_account);				header('Location: /');			} else {				$loginView = new loginView();				$loginView->showLoginForm(TRUE);			}		} else {			$loginView = new loginView();			$loginView->showLoginForm();		}	}}