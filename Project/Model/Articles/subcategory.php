<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class subcategory
{
	private $subcategory_id;
	private $subcategory_title;
	private $description;
	private $category_id;
	private $subcategory_url;
	
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
						article_subcategories
					WHERE
						subcategory_id = :subcategory_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
			
			$this->subcategory_title	= $result['subcategory_title'];
			$this->description			= $result['subcategory_description'];
			$this->category_id			= $result['category_id'];
			$this->subcategory_url		= $result['subcategory_url'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function get_subcategory_title($subcategory_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						subcategory_title
					FROM
						article_subcategories
					WHERE
						subcategory_id = :subcategory_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
	
			return $result['subcategory_title'];
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function insert()
	{
		try{
			$pdo_connection = starfishDatabase::getConnection();
			$pdo_connection->beginTransaction();
						
			$sql = "INSERT INTO
						article_subcategories
						(
							`subcategory_title`,
							`subcategory_url`,
							`category_id`
						)
					VALUES
						(
							:subcategory_title,
							:subcategory_url,
							:category_id
						)
					";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_title', $this->subcategory_title, PDO::PARAM_STR);
			$pdo_statement->bindParam(':subcategory_url', $this->subcategory_url, PDO::PARAM_STR);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
			$this->subcategory_id = $pdo_connection->lastInsertId();
			$pdo_connection->commit();
				
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
						article_subcategories
					WHERE
						subcategory_id = :subcategory_id
					";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
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
						article_subcategories
					SET
						`subcategory_title`			= :subcategory_title,
						`subcategory_url`			= :subcategory_url,
						`subcategory_description`	= :subcategory_description
					WHERE
						subcategory_id = :subcategory_id
					";
		
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_title', $this->subcategory_title, PDO::PARAM_STR);
			$pdo_statement->bindParam(':subcategory_description', $this->description, PDO::PARAM_STR);
			$pdo_statement->bindParam(':subcategory_url', $this->subcategory_url, PDO::PARAM_STR);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}