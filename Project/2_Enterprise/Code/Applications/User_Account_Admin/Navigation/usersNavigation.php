<?php 	
class usersNavigation
{
	//====================================================================================================================
	public static function displayUsersNavigation()
	{
		
		$articlesArray = array
		(
			'Rizza',
			'Gert',
			'Ami',
			'Myk',
			'Noel'		
		);
		
		$content = "<ul id='articles_nav'>";
		$content .= self::get_ListItems_from_UsersArray($articlesArray);
		$content .= "</ul>";
	
		return $content;
	}
	
	
	
	//====================================================================================================================
	
	private function get_ListItems_from_UsersArray($articlesArray)
	{
		$content = "<h5>Users</h5>";
		foreach($articlesArray as $article)
		{
			$application_url_name = routes::getInstance()->getCurrentTopLevelURLName();
			$link_text = "$article";
			$url_name =  "$article";
				
			$ahref = "<a href='/".$application_url_name."/".$url_name."'>".$link_text."</a>";
				
			$content .= '<li>'.$ahref.'</li>';
		}
		return $content;
	}
	
	
	
}
	
?>