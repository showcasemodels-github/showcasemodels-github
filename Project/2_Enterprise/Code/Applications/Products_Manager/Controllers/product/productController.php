<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'productView.php';

class productController extends applicationsSuperController
{
	public function indexAction()
	{
		$productView = new productView();
		$productView->displayMainLayout();
	}
	
	public function editAction()
	{
		$productView = new productView();
		$productView->displayProductEditor();
	}
}	
	


