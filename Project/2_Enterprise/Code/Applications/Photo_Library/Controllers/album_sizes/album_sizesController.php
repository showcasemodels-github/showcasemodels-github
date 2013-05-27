<?php
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Controllers/album_sizes/album_sizesController.php';

require_once 'Project/Model/Photo_Library/album_size/album_size.php';
require_once 'Project/Model/Photo_Library/album/album.php';

class album_sizesController extends applicationsSuperController
{
	public function indexAction() { header('Location: /image_library'); }

//-------------------------------------------------------------------------------------------------	
	
	public function addAction()
	{	
		$album_id	= $this->getValueOfURLParameterPair('add');
	
		if(isset($album_id))
		
			if(isset($_POST['width'], $_POST['height']))
			{
			 	$height				= $_POST['height'];
			 	$width				= $_POST['width'];
			 	$album_size_folder	= $height.'x'.$width;
			 	
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
			 	
			 	if(!file_exists(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder').'/'.$album_size_folder))
			 	{
				 	//add album in Data/Images folder
				 	$data_handler = new dataHandler();
			
				 	//replace spaces in folder names with underscores so there won't be a problem with the URLs
				 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder').'/'.$album_size_folder);
				 	$data_handler->create_directory(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder').'/'.$album_size_folder.'_thumb');
				 	
				 	//add album size to database
				 	$album_size = new album_size();
				 	
				 	$album_size->__set('album_id', $album_id);
				 	$album_size->__set('dimensions', $album_size_folder);
				 	$album_size->insert();
						
					$pdo_connection->commit();
				 }
			 	
			 	header('Location: /image_library/albums/view/'.$album_id.'/'.$album_size->__get('size_id'));
			}
			
			else
				header('Location: /image_library/albums/view/'.$album_id);
			
		else
			header('Location: /image_library');
			
	}
	
//=======================================================================================================================
	
	public function resizeAction()
	{
		$album_id	= $this->getValueOfURLParameterPair('resize');
		$size_id	= $this->getValueOfURLParameterPair($album_id);
		
		if(isset($album_id))
		
			if(isset($size_id))
			{
				if(isset($_POST['width'], $_POST['height']))
				{
			
					$width		= $_POST['width'];
					$height		= $_POST['height'];
					
					//start SQL transaction
					/* NOTE: SQL transactions should be used when a combination of insert, update
					 * and delete commands is executed
					 */
					$pdo_connection = starfishDatabase::getConnection();
					$pdo_connection->beginTransaction();
					
					$album_size = new album_size();
					$album_size->__set('size_id', $size_id);
					$album_size->select();
					
					$album = new album();
					$album->__set('album_id', $album_id);
					$album->select();
					
					require_once 'Project/2_Enterprise/Code/Applications/Photo_Library/Modules/directories/directoryHandler.php';
					
					$dimensions = explode('x', $album_size->__get('dimensions'));
							
					$directory_handler = new directoryHandler();
					$directory_handler->resize_directory('Data/Images/'.$album->__get('album_folder').'/', $dimensions[0], $dimensions[1], $width, $height);
					
					$directory_handler->rename_thumb_directory('Data/Images/'.$album->__get('album_folder').'/'.$dimensions[0].'x'.$dimensions[1].'_thumb',
												'Data/Images/'.$album->__get('album_folder').'/'.$width.'x'.$height.'_thumb');
					
					$album_size->__set('dimensions', $width.'x'.$height);
					$album_size->update();
						
					$pdo_connection->commit();
				}
				 	
				 header('Location: /image_library/albums/view/'.$album_id.'/'.$size_id);
			}
			
			else
				header('Location: /image_library/albums/view/'.$album_id);
			
		else
			header('Location: /image_library');
	}
	
//=======================================================================================================================
	
	public function deleteAction()
	{
		$album_id	= $this->getValueOfURLParameterPair('delete');
		$size_id	= $this->getValueOfURLParameterPair($album_id);
		
		if(isset($album_id))
		{
			if(isset($size_id))
			{
				//start SQL transaction
				/* NOTE: SQL transactions should be used when a combination of insert, update
				 * and delete commands is executed
				 */
				$pdo_connection = starfishDatabase::getConnection();
				$pdo_connection->beginTransaction();
			 	
			 	//select album from database
			 	$album_size = new album_size();
			 	$album_size->__set('size_id', $size_id);
			 	$album_size->select();
			 	
			 	//select album from database
			 	$album = new album();
			 	$album->__set('album_id', $album_size->__get('album_id'));
			 	$album->select();
			 	
			 	//delete album
			 	$data_handler = new dataHandler();
			 	$data_handler->delete_directory_recurse_svn(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder').
			 												'/'.$album_size->__get('dimensions'));
			 	$data_handler->delete_directory_recurse_svn(STAR_SITE_ROOT.'/Data/Images/'.$album->__get('album_folder').
			 												'/'.$album_size->__get('dimensions').'_thumb');
			 	//die;
			 	$album_size->delete();
					
				$pdo_connection->commit();
			}
			
			header('Location: /image_library/albums/view/'.$album_id);
		}
			
		else
			header('Location: /image_library');
	}
}