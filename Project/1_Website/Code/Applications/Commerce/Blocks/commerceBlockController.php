<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'commerceBlockView.php';
//----------------------------------------------------------

class commerceBlockController 
{
	//===============================================================================================================================
	 public function shoppingCartControlPanel()
	 {
	 	$commerceBlocView = new commerceBlockView();
	 	return $commerceBlocView->shoppingCartControlPanel();
	 }
	 
	 //===============================================================================================================================
	 
	 public function addToShoppingCartLink($product)
	 {
	 	$commerceBlockView = new commerceBlockView();
	 	return $commerceBlockView->addToShoppingCartLink($product);
	 }
	 
	 
	 //===============================================================================================================================
	 public function shoppingCartDropDownBoxHolder()
	 {
		$commerceBlocView = new commerceBlockView();
	 	return $commerceBlocView->shoppingCartDropDownBoxHolder();
	 	
	}
	 
}