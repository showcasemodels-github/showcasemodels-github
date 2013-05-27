<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class category
{
	private $category_id;
	private $category_title;
	private $category_url;
	
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------	
	
	public function select()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						*
					FROM
						article_categories
					WHERE
						category_id = :category_id";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$result = $pdo_statement->fetch();
				
			$this->category_title	= $result['category_title'];
			$this->category_url		= $result['category_url'];
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function selectFirst()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						*
					FROM
						article_categories
					LIMIT 0,1";
				
			$pdo_statement = $pdo_connection->query($sql);
			$result = $pdo_statement->fetch();
				
			$this->category_id		= $result['category_id'];
			$this->category_title	= $result['category_title'];
			$this->category_url		= $result['category_url'];
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
//-------------------------------------------------------------------------------------------------	
	
	public static function checkIfExists($category_title)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						COUNT(category_id) as existing
					FROM
						article_categories
					WHERE
						lower(category_title) = :category_title";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', strtolower($category_title), PDO::PARAM_STR);
			$pdo_statement->execute();
			
			$result = $pdo_statement->fetch();
				
			return $result['existing'];
				
		}
		catch(PDOException $pdoe)
		{
			return FALSE;
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function get_category_title($category_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						category_title
					FROM
						article_categories
					WHERE
						category_id = :category_id";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$result = $pdo_statement->fetch();
	
			return $result['category_title'];
				
		}
		catch(PDOException $pdoe)
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
						article_categories
						(
							`category_title`,
							`category_url`
						)
					VALUES
						(
							:category_title,
							:category_url
						)";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $this->category_title, PDO::PARAM_STR);
			$pdo_statement->bindParam(':category_url', $this->category_url, PDO::PARAM_STR);
			$pdo_statement->execute();
			
			$this->category_id = $pdo_connection->lastInsertId();
				
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
						article_categories
					SET
						category_title	= :category_title,
						category_url	= :category_url
					WHERE
						category_id = :category_id";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $this->category_title, PDO::PARAM_STR);
			$pdo_statement->bindParam(':category_url', $this->category_url, PDO::PARAM_STR);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function delete()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "DELETE FROM
						article_categories
					WHERE
						category_id = :category_id
					";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}