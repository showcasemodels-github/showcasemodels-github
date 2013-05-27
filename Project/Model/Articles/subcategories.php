<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'subcategory.php';

class subcategories
{
	private $array_of_subcategories = array();
	private $category_id;
	
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
			
			$sql = "
					SELECT
						*
					FROM
						article_subcategories
					";
			
			$pdo_statement = $pdo_connection->query($sql);
			$results = $pdo_statement->fetchAll();
				
			foreach($results as $result)
			{
				$subcategory = new subcategory();
				
				$subcategory->__set('subcategory_id', $result['subcategory_id']);
				$subcategory->__set('subcategory_title', $result['subcategory_title']);
				$subcategory->__set('description', $result['subcategory_description']);
				$subcategory->__set('category_id', $result['category_id']);
				
				$this->array_of_subcategories[] = $subcategory;
			}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function selectByCategoryID($category_id)
	{
		$array_of_subcategories = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						*
					FROM
						article_subcategories
					WHERE
						category_id = :category_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$results = $pdo_statement->fetchAll();
			
			foreach($results as $result)
			{
				$subcategory = new subcategory();
					
				$subcategory->__set('subcategory_id', $result['subcategory_id']);
				$subcategory->__set('subcategory_title', $result['subcategory_title']);
				$subcategory->__set('description', $result['subcategory_description']);

				$this->array_of_subcategories[] = $subcategory;
			}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function selectByDesignerID($designer_id)
	{
		$array_of_subcategories = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						s.subcategory_id, subcategory_title, subcategory_description
					FROM
						article_subcategories s
					INNER JOIN
						articles p
					ON
						p.subcategory_id = s.subcategory_id
					WHERE
						designer_id = :designer_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':designer_id', $designer_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$results = $pdo_statement->fetchAll();
			
			foreach($results as $result)
			{
				$subcategory = new subcategory();
					
				$subcategory->__set('subcategory_id', $result['subcategory_id']);
				$subcategory->__set('subcategory_title', $result['subcategory_title']);
				$subcategory->__set('description', $result['subcategory_description']);

				$this->array_of_subcategories[] = $subcategory;
			}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}