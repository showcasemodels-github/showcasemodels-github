<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'Project/Model/Photo_Library/image/image.php';
require_once 'category_image.php';

class category_images
{
 	public static function selectThumbnailByType($category_id, $used_for = 'gallery', $is_thumbnail = FALSE)
	{
		$array_of_images = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						category_image_id,
						i.image_id,
						album_folder,
						dimensions,
						filename,
						filename_ext,
						used_for
					FROM
						category_images pi
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
					AND
						category_id = :category_id
					";
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':used_for', $used_for, PDO::PARAM_STR);
				$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$results = resultCleaner::cleanResults($pdo_statement->fetchAll(PDO::FETCH_ASSOC));
				
				foreach ($results as $result)
				{
					$thumbnail = '';
					
					if($is_thumbnail) $thumbnail = '_thumb';
					
					$full_path = $result['album_folder'].'/'.$result['dimensions'].$thumbnail.'/'.$result['filename'].$result['filename_ext'];
					
					$category_image	= new category_image();
					$category_image->__set('category_id', $category_id);
					$category_image->__set('category_image_id', $result['category_image_id']);
					$category_image->__set('image_id', $result['image_id']);
					$category_image->__set('full_path', $full_path);
					$category_image->__set('used_for', $result['used_for']);
					
					$array_of_images[] = $category_image;
				}
				
				return $array_of_images;
				
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function selectArticleImageIDs($category_id)
	{
		$array_of_ids = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						category_image_id
					FROM
						category_images
					WHERE
						category_id = :category_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			foreach($results as $result)
				$array_of_ids[] = $result['category_image_id'];
			
			return $array_of_ids;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function deleteByArticleID($category_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "DELETE FROM
						category_images
					WHERE
						category_id = :category_id
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
				$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
}
?>