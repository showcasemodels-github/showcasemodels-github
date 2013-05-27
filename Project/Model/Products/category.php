<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class category
{
	private $category_id;
	private $category_title;
	private $category_url;
	private $route_id;
	private $permalink;
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
						category_id,
						p.route_id,
						category_title,
						permalink
					FROM
						product_categories p
					INNER JOIN
						route r
					ON
						p.route_id = r.route_id	
					WHERE
						category_id = :category_id";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$result = $pdo_statement->fetch();
				
			$this->category_title		= $result['category_title'];
			$this->permalink			= $result['permalink'];
			$this->route_id				= $result['route_id'];
				
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
						product_categories
					LIMIT 0,1";
				
			$pdo_statement = $pdo_connection->query($sql);
			$result = $pdo_statement->fetch();
				
			$this->category_id		= $result['category_id'];
			$this->category_title	= $result['category_title'];
				
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
						product_categories
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
						product_categories
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
	
	public static function get_category_id($category_title)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
							category_id
						FROM
							product_categories
						WHERE
							category_title = :category_title";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $category_title, PDO::PARAM_INT);
			$pdo_statement->execute();
				
			$result = $pdo_statement->fetch();
	
			return $result['category_id'];
	
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
						product_categories
						(
							`category_title`,
							`category_url`,
							`route_id`
						)
					VALUES
						(
							:category_title,
							:category_url,
							:route_id
						)";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $this->category_title, PDO::PARAM_INT);
			$pdo_statement->bindParam(':category_url', $this->category_url, PDO::PARAM_INT);
			$pdo_statement->bindParam(':route_id', $this->route_id, PDO::PARAM_INT);
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
						product_categories
					SET
						category_title	= :category_title
					WHERE
						category_id = :category_id";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $this->category_title, PDO::PARAM_INT);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function delete($category_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "DELETE FROM
						product_categories
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