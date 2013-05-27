<?php
require_once(FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php');

class mainAppView extends viewSuperClass_Core
{
	private $current_application_ID;
	
	public function __construct()
	{
		$this->current_application_ID = applicationsRoutes::getInstance()->getCurrentApplicationID();
	}
	
	public function displayMainApplicationLayout()
	{
		
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/'.$this->current_application_ID.'/Main_App_Layout/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('SETTINGS_CS'=>$content));
		
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/'.$this->current_application_ID.'/Main_App_Layout/templates/inpage_javascript.js');
		response::getInstance()->addContentToStack('local_javascript_bottom',array('SETTINGS_JS'=>$content));
		
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/'.$this->current_application_ID.'/Main_App_Layout/templates/main_app_layout.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
}
?>