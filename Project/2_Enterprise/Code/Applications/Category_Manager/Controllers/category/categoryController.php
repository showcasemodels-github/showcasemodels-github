<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'categoryView.php';

class categoryController extends applicationsSuperController
{
	public function indexAction()
	{
		$categoryView = new categoryView();
		$categoryView->displayMainLayout();
	}
	
	public function editAction()
	{
		$categoryView = new categoryView();
		$categoryView->displaySubcategoryEditor();
	}
}	
	


