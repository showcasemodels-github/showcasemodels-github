<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'albumsView.php';

require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Controllers/images/imagesController.php';
require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Controllers/album_sizes/album_sizesController.php';

require_once 'Project/Model/Photo_Library/album/album.php';
require_once 'Project/Model/Photo_Library/album/albums.php';
require_once 'Project/Model/Photo_Library/album_size/album_size.php';
require_once 'Project/Model/Photo_Library/image/images.php';

class albumsController extends applicationsSuperController
{	
	
//---------------------------------------------------------------------------------------------------------------
		
	public function indexAction()
	{
		$albums = new albums();
		$albums->select();
		
		$album_array	= $albums->__get('array_of_albums');
		$temp_array		= array();
		
		foreach($album_array as $key=>$album)
			if(file_exists(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder')))
				$temp_array[] = $album;
			
		$albumsView = new albumsView();
		$albumsView->_set('array_of_albums', $temp_array);
		$albumsView->displayContentColumn();
	}
	
//---------------------------------------------------------------------------------------------------------------
		
	public function addAction()
	{	
		if(isset($_POST['album_title'], $_POST['height'], $_POST['width']))
		{
		 	$album_title		= $_POST['album_title'];
		 	$height				= $_POST['height'];
		 	$width				= $_POST['width'];
		 	$album_folder		= str_replace(' ', '-', $album_title).'_album';
		 	$album_size_folder	= $height.'x'.$width;
		 	
		 	if(!file_exists(STAR_SITE_ROOT.'/Data/Images/'.$album_folder))
		 	{
				//start SQL transaction
				/* NOTE: SQL transactions should be used when a combination of insert, update
				 * and delete commands is executed
				 */
				$pdo_connection = starfishDatabase::getConnection();
				$pdo_connection->beginTransaction();
			 	
			 	//add album to database
			 	$album = new album();
			 	
			 	$album->__set('album_title', $album_title);
			 	$album->__set('album_folder', $album_folder);
			 	$album->insert();
			 	
			 	//add album size to database
			 	$album_size = new album_size();
			 	
			 	$album_size->__set('album_id', $album->__get('album_id'));
			 	$album_size->__set('dimensions', $album_size_folder);
			 	$album_size->insert();
					
				$pdo_connection->commit();
			 	
			 	//add album in Data/Images folder
			 	$data_handler = new dataHandler();
		
			 	//replace spaces in folder names with underscores so there won't be a problem with the URLs
			 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album_folder);
			 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album_folder.'/'.$album_size_folder);
			 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album_folder.'/'.$album_size_folder.'_thumb');
			 	
			 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album_folder.'/original');
			 	//do we still need image cropping?
			 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album_folder.'/crop_tool_images');
			 	
			 	header('Location: /image_library/albums/view/'.$album->__get('album_id'));
		 	}
		 	
			else
				header('Location: /image_library');
			
		}
		
		else
			header('Location: /image_library');
	}
	
//---------------------------------------------------------------------------------------------------------------
		
	public function viewAction()
	{
		$album_id	= $this->getValueOfURLParameterPair('view');
		$size_id	= $this->getValueOfURLParameterPair($album_id);
		$size_id	= $size_id === NULL ? 0:$size_id;
		
		if(isset($album_id, $size_id))
		{
			$imagesController = new imagesController();
			$imagesController->getImagesInAlbum($album_id, $size_id);
		}
		
		else
			header('Location: /image_library');
	}
	
//---------------------------------------------------------------------------------------------------------------
		
	public function renameAction()
	{
		$album_id = $this->getValueOfURLParameterPair('rename');
		
		if(isset($album_id))
		{
			//start SQL transaction
			/* NOTE: SQL transactions should be used when a combination of insert, update
			 * and delete commands is executed
			 */
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
			
			$album_title	= $_POST['album_title'];
			//replace spaces in folder names with underscores so there won't be a problem with the URLs
			$album_folder	= str_replace(' ', '-', $album_title).'_album';
			 
			//select album from database
			$album = new album();
			$album->__set('album_id', $album_id);
			$album->select();
			
			//recursively copies the files and directories, then deletes the original folder
			$original_path	= 'Data/Images/'.$album->__get('album_folder');
			$new_path		= 'Data/Images/'.$album_folder;
			
			require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Modules/directories/directoryHandler.php';
			
			$directory_handler = new directoryHandler();
			
			$directory_handler->rename_directory($original_path, $new_path);
			
			$album->__set('album_title', $album_title);
			$album->__set('album_folder', $album_folder);
			$album->update();
				
			$pdo_connection->commit();
			
			if(isset($_POST['redirect_to_albums']) && $_POST['redirect_to_albums'] == 'yes')
				header('Location: /image_library');
			else
				header('Location: /image_library/albums/view/'.$album_id);
		}
		
		else
			header('Location: /image_library');
	}
	
//---------------------------------------------------------------------------------------------------------------
		
	public function deleteAction()
	{
		$album_id = $this->getValueOfURLParameterPair('delete');
		
		if(isset($album_id))
		{
			//start SQL transaction
			/* NOTE: SQL transactions should be used when a combination of insert, update
			 * and delete commands is executed
			 */
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
		 	
		 	//select album from database
		 	$album = new album();
		 	$album->__set('album_id', $album_id);
		 	$album->select();
		 	
		 	//delete from database
		 	$album->delete();
				
			$pdo_connection->commit();
		 	
		 	//delete album
		 	$data_handler = new dataHandler();
		 	$data_handler->delete_directory_recurse_svn('Data/Images/'.$album->__get('album_folder'));
		}
	 	
	 	header('Location: /image_library');
	}
}