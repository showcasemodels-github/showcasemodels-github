<?php 
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'route.php';

class route
{
	private $array_of_route;
	private $page_id;
	
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{		if(property_exists($this, $field)) return $this->{$field};		else return NULL;	}
//-------------------------------------------------------------------------------------------------		public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }//-------------------------------------------------------------------------------------------------	public function select()	{		try		{			$pdo_connection = starfishDatabase::getConnection();
			$sql = "SELECT						*					FROM						route r					WHERE						route_id = :route_id					";			$pdo_statement = $pdo_connection->query($sql);			$results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($results as $result)			{				$route = new route();				$route->__set('route_id', $result['route_id']);				$route->__set('permalink', $result['permalink']);				$route->__set('page_id',  $result['page_id']);
				$this->array_of_route[] = $route;			}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectByPageID()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						*
					FROM
						route r
					WHERE
						page_id = :page_id
					";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':page_id', $this->page_id, PDO::PARAM_STR);
			$pdo_statement->execute();
			
			foreach($results as $result)
			{
				$route = new route();
				
				$route->__set('route_id', $result['route_id']);
				$route->__set('permalink', $result['permalink']);
				$route->__set('page_id',  $result['page_id']);
				
				$this->array_of_route[] = $route;
			}
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}
?>