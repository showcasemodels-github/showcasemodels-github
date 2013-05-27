<?php 	
class applicationsDispatcher
{
	
	private $_ApplicationController;
	
	//====================================================================================================================
	//===			 PRE DISPATCH
	//====================================================================================================================	
	public function predispatch()
	{
		//might put login/logout stuff here
		//clean out the project front controller a little
		
		//NOTE: you don't put authorization here because not all applications require log in
	}
	//====================================================================================================================
	//===			 DISPATCH
	//====================================================================================================================	
	public function dispatch() {
		
		$currentApplicationID = applicationsRoutes::getInstance()->getCurrentApplicationID();
	
		$currentControllerID = applicationsRoutes::getInstance()->getCurrentControllerID();
		
		
		if (is_null($currentApplicationID))
		{
			header('Location: /');
		}
		
		
		if (globalRegistry::getInstance()->getRegistryValue('modifier','ajax')===true)	
		{
				require_once('Project/'.DOMAIN.'/Code/Applications/'.$currentApplicationID.'/Ajax/'.strtolower($currentApplicationID).'AjaxController.php');
				$applicationControllerString = strtolower($currentApplicationID).'AjaxController';
		}
		else
		{
			require_once('Project/'.DOMAIN.'/Code/Applications/'.$currentApplicationID.'/Controllers/'.$currentControllerID.'/'.$currentControllerID.'Controller.php');
			$applicationControllerString = $currentControllerID.'Controller';
		}
		$this->_ApplicationController = new $applicationControllerString;
		
		
		if ((applicationsRoutes::getInstance()->getRequiresLogin()=="yes") && ($currentControllerID != "login") && ($currentControllerID != "registration"))
		{
			//if the user is not going to login on his own accord then go to the login page if the page 
			// he is trying to go to is restricted
		
			//now, we might have a problem regarding the registration if its application requires login
			//so we'll have to check if we're in the registration controller
			
			//you don't even need Zend Session here because it's already required in authorization
			require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';
			
			if(authorization::areWeLoggedIn() === FALSE)
			{
				//we do it this way so that certain applicatiob classes can override the super Login action
				globalRegistry::getInstance()->setRegistryValue('event','login_application_grabs_control','true');
				$this->_ApplicationController->doLogin();
			}
	
		}
		
		//This function won't be reached if the control goes to doLogin, as that function does a redirect.
		
		if (globalRegistry::getInstance()->getRegistryValue('event','login_application_grabs_control')=='false'){
			
			$parametersArray = request::getInstance()->getParametersArray();
			
			if (!empty($parametersArray))
			{
				//speculative try at first parameter in string as Action name
				$this->_ApplicationController->speculativeDispatch();
			}
			else
			{
				$this->_ApplicationController->normalDispatch();
			}
		}
		
		//pre dispatch
		//dispatch		
		
		
	}
	//====================================================================================================================
	//===			 POST DISPATCH
	//====================================================================================================================	
	public function postdispatch() 
	{
		if (globalRegistry::getInstance()->getRegistryValue('event','login_application_grabs_control')=='false'){
			$this->_ApplicationController->postdispatch();
		}
	}
}
	
?>