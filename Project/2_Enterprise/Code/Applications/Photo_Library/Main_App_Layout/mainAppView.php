<?php
require_once(FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php');

class mainAppView extends viewSuperClass_Core
{
	public function display_Main_Application_Layout()
	{
		$this->displayNewAlbumDialog();
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Photo_Library/Main_App_Layout/templates/inpage_javascript.js');
		response::getInstance()->addContentToStack('local_javascript_bottom',array('PHOTOLIBRARY_JS'=>$content));
		
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Photo_Library/Main_App_Layout/templates/css_links.phtml');
		response::getInstance()->addContentToStack('local_css',array('PHOTOLIBRARY_CSS'=>$content));
		
		$currentApplicationID = applicationsRoutes::getInstance()->getCurrentApplicationID();
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/'.$currentApplicationID.'/Main_App_Layout/templates/main_app_layout.phtml');
		response::getInstance()->addContentToTree(array('MAIN_CONTENT'=>$content));
	}
	
	
	public function display_Photo_and_Albums_Navigation()
	{
		require_once('Project/'.DOMAIN.'/Code/Applications/Photo_Library/Navigation/photos_and_albumsNavigation.php');
		$content = photos_and_albumsNavigation::displayPhotoAndAlbumsNavigation();
		response::getInstance()->addContentToTree(array('APPLICATION_LEFT_COLUMN'=>$content));
	}
	
//=================================================================================================
	
	private function displayNewAlbumDialog()
	{
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/Photo_Library/Controllers/templates/albums/new_album_dialog.phtml');
		response::getInstance()->addContentToTree(array('NEW_ALBUM_DIALOG'=>$content));
	}
	
//=================================================================================================
}
?>