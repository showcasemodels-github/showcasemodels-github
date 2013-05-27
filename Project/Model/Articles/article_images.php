<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'Project/Model/Photo_Library/image/image.php';
require_once 'article_image.php';

class article_images
{
 	public static function selectThumbnailByType($article_id, $used_for = 'gallery', $is_thumbnail = FALSE)
	{
		$array_of_images = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						article_image_id,
						i.image_id,
						album_folder,
						dimensions,
						filename,
						filename_ext,
						used_for
					FROM
						article_images pi
					INNER JOIN
						images i
					ON
						pi.image_id = i.image_id
					INNER JOIN
						album_image_sizes s
					ON
						s.size_id = i.size_id
					INNER JOIN
						albums a
					ON
						s.album_id = a.album_id
					WHERE
						used_for = :used_for	
					";
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':used_for', $used_for, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$results = resultCleaner::cleanResults($pdo_statement->fetchAll(PDO::FETCH_ASSOC));
				
				foreach ($results as $result)
				{
					$thumbnail = '';
					
					if($is_thumbnail) $thumbnail = '_thumb';
					
					$full_path = $result['album_folder'].'/'.$result['dimensions'].$thumbnail.'/'.$result['filename'].$result['filename_ext'];
					
					$article_image	= new article_image();
					$article_image->__set('article_id', $article_id);
					$article_image->__set('article_image_id', $result['article_image_id']);
					$article_image->__set('image_id', $result['image_id']);
					$article_image->__set('full_path', $full_path);
					$article_image->__set('used_for', $result['used_for']);
					
					$array_of_images[] = $article_image;
				}
				
				return $array_of_images;
				
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function selectArticleImageIDs($article_id)
	{
		$array_of_ids = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						article_image_id
					FROM
						article_images
					WHERE
						article_id = :article_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			foreach($results as $result)
				$array_of_ids[] = $result['article_image_id'];
			
			return $array_of_ids;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function deleteByArticleID($article_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "DELETE FROM
						article_images
					WHERE
						article_id = :article_id
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
				$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
	public static function getImagePath($image_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
		
			$sql = "SELECT
								i.image_id,
								a.album_folder,
								ai.dimensions,
								i.filename,
								i.filename_ext
							FROM
								images i
							INNER JOIN
								album_image_sizes ai
							ON
								i.album_id = ai.album_id
							INNER JOIN
								albums a
							ON
								i.album_id = a.album_id
							WHERE
								image_id = :image_id	
							";
		
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':image_id', $image_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
			$result = resultCleaner::cleanResults($pdo_statement->fetchAll(PDO::FETCH_ASSOC));
			$result = $result[0];
			$result = 'http://starfish_enterprise/'.PHOTO_LIBRARY_DIRECTORY.'/'.$result['album_folder'].'/'.$result['dimensions'].'/'.$result['filename'].$result['filename_ext'];
		
			return $result;
		
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}
?>