<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'category.php';

class categories
{
	private $array_of_categories = array();
	
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
					";
			
				$pdo_statement = $pdo_connection->query($sql);
				$results = $pdo_statement->fetchAll();
				
				foreach($results as $result)
				{
					$category = new category();
					
					$category->__set('category_id', $result['category_id']);
					$category->__set('category_title', $result['category_title']);
					
					$this->array_of_categories[] = $category;
				}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function selectCount()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						COUNT(category_id) as count
					FROM
						article_categories
					";
			
				$pdo_statement = $pdo_connection->query($sql);
				$result = $pdo_statement->fetch();
				
				return $result['count'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
}