<?php
require_once 'Project/Code/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/Code/2_Enterprise/Applications/Products/Controllers/products/productsController.php';

class productsAjaxController extends applicationsSuperController
{
	private $product_type;
	
	public function __construct()
	{
		parent::__construct();
		$this->product_type = routes::getInstance()->getCurrentTopLevelPageID();
	}
	
//-------------------------------------------------------------------------------------------------	

	public function execute_commandAction()
	{		
		/* if(isset($_REQUEST['product_id']))
		{
			$productController = new productsController();
			$productController->deleteProduct($_REQUEST['product_id'], TRUE);
		} */
		
		jQuery::getResponse();
	}
	
//-------------------------------------------------------------------------------------------------	

	public function delete_productAction()
	{		
		if(isset($_REQUEST['product_id']))
		{
			$productController = new productsController();
			$productController->deleteProduct($_REQUEST['product_id'], TRUE);
		}
		
		jQuery::getResponse();
	}
	
//-------------------------------------------------------------------------------------------------	

	public function check_titleAction()
	{		
		require_once 'Project/Code/System/Products/product.php';
		
		if(product::checkIfExists($this->product_type, $_REQUEST['title']))
			jQuery::addMessage('exists');
		else
			jQuery::addMessage('notexists');
		
		jQuery::getResponse();
	}
	
}