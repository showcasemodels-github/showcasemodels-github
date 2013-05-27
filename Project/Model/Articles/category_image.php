<?php 
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'Project/Model/Photo_Library/image/image.php';

class category_image
{
	private $category_image_id;
	private $category_id;
	private $image_id;
	private $used_for;
	
	private $full_path;
	
	public function __construct()
	{
		$this->image_id = 1;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------

	public function selectThumbnailByType($category_id, $used_for, $is_thumbnail = FALSE)
	{
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
					LEFT JOIN
						images i
					ON
						pi.image_id = i.image_id
					LEFT JOIN
						album_image_sizes s
					ON
						s.size_id = i.size_id
					LEFT JOIN
						albums a
					ON
						s.album_id = a.album_id
					WHERE
						category_id = :category_id
					AND
						used_for = :used_for	
					";
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
				$pdo_statement->bindParam(':used_for', $used_for, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));
				$thumbnail = '';
				
				if($is_thumbnail) $thumbnail = '_thumb';
				
				$full_path = $result['album_folder'].'/'.$result['dimensions'].$thumbnail.'/'.$result['filename'].$result['filename_ext'];
				
				$this->category_image_id	= $result['category_image_id'];
				$this->category_id		= $category_id;
				$this->image_id			= $result['image_id'];
				$this->used_for			= $result['used_for'];
				$this->full_path		= $full_path;
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function insert()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "INSERT INTO
						category_images
						(
							category_id,
							image_id,
							used_for
						)
					VALUES
						(
							:category_id,
							:image_id,
							:used_for
						)
					";
			//var_dump($this); die;
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':image_id', $this->image_id, PDO::PARAM_STR);
			$pdo_statement->bindParam(':used_for', $this->used_for, PDO::PARAM_STR);
			$pdo_statement->execute();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function update()
	{
		try 
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "UPDATE
						category_images
					SET
						image_id = :image_id
					WHERE
						category_image_id = :category_image_id
					";
			$pdo_statement = $pdo_connection->prepare($sql);
			//bindParam is used so that SQL inputs are escaped.
			//This is to prevent SQL injections!
			$pdo_statement->bindParam(':image_id', $this->image_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':category_image_id', $this->category_image_id, PDO::PARAM_INT);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function delete($category_image_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "DELETE FROM
						category_images
					WHERE
						category_image_id = :category_image_id
					";

			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_image_id', $category_image_id, PDO::PARAM_INT);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}
?>