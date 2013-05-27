<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';

class albumsView  extends applicationsSuperView
{
	private $template_location;
	
	private $array_of_albums;
	private $album;
	
//-------------------------------------------------------------------------------------------------	

	public function _get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function _set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------	

	public function displayContentColumn()
	{
		$this->displayAlbumHeader();
	
		$this->displayAlbums();
	
		$content = $this->renderTemplate('Project/'.DOMAIN.'/Design/Applications/Photo_Library/Controllers/templates/albums/albums_content_column.phtml');
		response::getInstance()->addContentToTree(array('CONTENT_COLUMN'=>$content));
	
	}

//-------------------------------------------------------------------------------------------------	
	
	private function displayAlbumHeader()
	{
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Photo_Library/Controllers/templates/albums/album_header.phtml');
		response::getInstance()->addContentToTree(array('APPLICATION_HEADER'=>$content));
	}

//-------------------------------------------------------------------------------------------------	
	
	private function displayAlbums()
	{
		$content = $this->renderTemplate('Project/2_Enterprise/Design/Applications/Photo_Library/Controllers/templates/albums/albums_listing.phtml');
		response::getInstance()->addContentToTree(array('ALBUMS'=>$content));
	}
	
}