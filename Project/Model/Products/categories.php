<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'category.php';

class categories
{
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
						category_url,
						permalink
					FROM
						product_categories p
					INNER JOIN
						route r
					ON
						p.route_id = r.route_id	
					";
			
				$pdo_statement = $pdo_connection->query($sql);
				$results = $pdo_statement->fetchAll();
				
				foreach($results as $result)
				{
					$category = new category();
					
					$category->__set('route_id', $result['route_id']);
					$category->__set('category_id', $result['category_id']);
					$category->__set('permalink', $result['permalink']);
					$category->__set('category_title', $result['category_title']);
					$category->__set('category_url', $result['category_url']);
					
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
						product_categories
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
	
//---------------------------------------------------------------------------------------------------

	public function selectCategoriesAndSubCategories()
	{
		try 
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT	
						*
					FROM
						products p
					INNER JOIN
						product_categories pc
					ON
						pc.category_id = p.category_id
					LEFT JOIN
						product_subcategories ps
					ON
						p.subcategory_id = ps.subcategory_id
					ORDER BY
						subcategory_title DESC";
				
				$pdo_statement = $pdo_connection->query($sql);
				$results = $pdo_statement->fetchAll();
				
				$this->array_of_categories = $results;
			} 
			catch(PDOException $e)
			{
				throw new Exception($pdoe);
			}
		}
}