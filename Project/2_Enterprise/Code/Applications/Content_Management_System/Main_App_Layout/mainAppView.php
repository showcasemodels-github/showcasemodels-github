<?php
require_once(FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php');

class mainAppView extends viewSuperClass_Core
{
	
	public function display_Main_Application_Layout()
	{
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Content_Management_System/Main_App_Layout/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('CMS CS'=>$content));
		
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/Content_Management_System/Main_App_Layout/templates/main_app_layout.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
		
	}
	
	
	public function display_Viewing_Type_Option_Links()
	{
		require_once('Project/'.DOMAIN.'/Code/Applications/Content_Management_System/Navigation/view_type_Navigation.php');
		$content = viewTypeNavigation::displayControllersAsNavigation('Content_Management_System'); 
		response::getInstance()->addContentToTree(array('APPLICATION_HEADER'=>$content));
	}
	
	
	public function display_Static_Pages_for_Navigation()
	{
		require_once('Project/'.DOMAIN.'/Code/Applications/Content_Management_System/Navigation/static_pages_Navigation.php');
		$content = staticPagesNavigation::displayStaticPagesNavigation('Content_Management_System');
		response::getInstance()->addContentToTree(array('APPLICATION_LEFT_COLUMN'=>$content));
	}
}
?>