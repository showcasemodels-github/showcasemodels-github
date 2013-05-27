<?php
require_once 'productsBlockView.php';

class productsBlockController
{
	public function getCategoryList($selected = '')
	{
		require_once 'Project/Model/Products/categories.php';
		
		$categories = new categories();
		$categories->select();
		
		$category_options = array();
		
		foreach($categories->getArrayOfCategories() as $option)
			$category_options[$option->getCategoryID()] = $option->getCategoryTitle();
		
		$view = new productsBlockView();
		
		return $view->displayCategoryDropDown($category_options, 'category_id', $selected);
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function getSubCategoryList($category_id = NULL, $selected = '')
	{
		require_once 'Project/Model/Products/subcategories.php';	
			
		$subcategories	= new subcategories();
		
		if($category_id == NULL)
		{
			$category = new category();
			
			$category->selectFirst();
			$subcategories->selectByCategoryID($category->getCategoryID());
		}
		
		else
			$subcategories->selectByCategoryID($category_id);
		
		$subcategory_options = array();
		
		foreach($subcategories->getArrayOfSubcategories() as $option)
			$subcategory_options[$option->getSubCategoryID()] = $option->getSubCategoryTitle();
		
		$view = new productsBlockView();
		
		return $view->displaySubCategoryDropDown($subcategory_options, 'subcategory_id', $selected);
	}
}