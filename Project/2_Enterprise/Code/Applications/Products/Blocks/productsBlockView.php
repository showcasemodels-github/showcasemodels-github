<?php
require_once 'Project/Code/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class productsBlockView  extends applicationsSuperView
{
	
//=================================================================================================	
//select input
	public function displayCategoryDropDown($options, $name, $selected = '')
	{	
		$content = '<select name="'.$name.'">';
		$content .= '<option></option>';
		
		foreach($options as $key=>$value)
		{
			$select = '';
			
			if($selected == $key)
				$select = ' selected="selected"';
			
			$content .= '<option value="'.$key.'"'.$select.'>'.$value.'</option>';
		}
		
		$content .= '</select>';
		
		return $content;
	}
	
//=================================================================================================	
//select input
	public function displaySubCategoryDropDown($options, $name, $selected = '')
	{	
		$content = '<select name="'.$name.'" >';
		$content .= '<option></option>';
		
		foreach($options as $key=>$value)
		{
			$select = '';
			
			if($selected == $key)
				$select = ' selected="selected"';
			
			$content .= '<option value="'.$key.'"'.$select.'>'.$value.'</option>';
		}
		
		$content .= '</select>';
		
		return $content;
	}
}