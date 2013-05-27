<?php
require_once 'Project/ApplicationsFramework/FrontController/applicationsFrontController.php';
require_once FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/controllerSuperClass_Core/controllerSuperClass_Core.php';
require_once('Model.php');
require_once('View.php');


class controller extends controllerSuperClass_Core
{
	public function indexAction()
	{	
		$applicationsAdminFrontController = new applicationsFrontController();
		$applicationsAdminFrontController->runApplicationFromWithinPage('Photo_Library');
	}	
	
}
?>