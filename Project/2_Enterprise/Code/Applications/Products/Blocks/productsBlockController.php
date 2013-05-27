<?php
require_once 'productsBlockView.php';

class productsBlockController
{
	public function getCategoryList($selected = '')
	{
		require_once 'Project/Code/System/Products/categories.php';
		
		$categories = new categories();
		$categories->select();
		
		$category_options = array();
		
		foreach($categories->__get('array_of_categories') as $option)
			$category_options[$option->__get('category_id')] = $option->__get('category_title');
		
		$view = new productsBlockView();
		
		return $view->displayCategoryDropDown($category_options, 'category_id', $selected);
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function getSubCategoryList($category_id = NULL, $selected = '')
	{
		require_once 'Project/Code/System/Products/subcategories.php';	
			
		$subcategories	= new subcategories();
		
		if($category_id == NULL)
		{
			$category = new category();
			
			$category->selectFirst();
			$subcategories->selectByCategoryID($category->__get('category_id'));
		}
		
		else
			$subcategories->selectByCategoryID($category_id);
		
		$subcategory_options = array();
		
		foreach($subcategories->__get('array_of_subcategories') as $option)
			$subcategory_options[$option->__get('subcategory_id')] = $option->__get('subcategory_title');
		
		$view = new productsBlockView();
		
		return $view->displaySubCategoryDropDown($subcategory_options, 'subcategory_id', $selected);
	}
}