<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
//require_once FILE_ACCESS_CORE_CODE.'/Modules/Pagination/pagination.php';
require_once 'subcategory.php';

class subcategories
{
	private $array_of_subcategories = array();
	private $array_of_products = array();
	private $array_of_random_products = array();
	private $category_id;
	private $category_title;
	private $subcategory_id;
	private $subcategory_url;
	private $posts_per_page;
	private $current_page;
	private $pages;
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
	public function setPostsPerPage($posts) {
		$this->posts_per_page = $posts;
	}
	
	public function setCurrentPage($current_page) {
		$this->current_page = $current_page;
	}
//-------------------------------------------------------------------------------------------------
	
	public function selectProducts($has_pagination = FALSE)
	{
		try
		{ 
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						p.product_id,
						p.route_id,
						p.category_id,
						ps.subcategory_id,
						product_title,
						category_url,
						subcategory_url,
						category_title,
						subcategory_title,
						description,
						product_price,
						date_created,
						date_updated,
						product_image_id,
						permalink,
						image_id
					FROM
						products p						
					LEFT JOIN
						product_images pi
					ON
						pi.product_id = p.product_id	
					INNER JOIN
						route r
					ON
						p.route_id = r.route_id
					LEFT JOIN
						product_categories pc
					ON
						p.category_id = pc.category_id
					LEFT JOIN
						product_subcategories ps
					ON
						p.subcategory_id = ps.subcategory_id
					WHERE
						ps.subcategory_id = :subcategory_id";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination();
				$pagination->setPostsPerPage($this->posts_per_page);
				$pagination->count_all_rows($pdo_statement);
				$pagination->setOffset($this->current_page);
				
				$this->pages = $pagination->price_limit_offset();
					
				$sql .= $pagination->getLimitClause();
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			}
			
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll(); 
			$this->saveResults($results);
	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}	
//=================================================================================================			
	public function select()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "
					SELECT
						*
					FROM
						product_subcategories
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
	
	public function selectBySubCategory()
	{
		try
		{ 
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT 
						subcategory_id,
						subcategory_title,
						subcategory_url,
						c.category_id,
						c.category_title
					FROM
						product_subcategories s
					INNER JOIN
						product_categories c
					ON
						s.category_id = c.category_id
					WHERE
						category_title = :category_title";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_title', $this->category_title, PDO::PARAM_STR);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
			$this->array_of_subcategories = $results;
			
			//echo "<pre>"; var_dump($this->array_of_subcategories); echo "</pre>"; die;
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
						product_subcategories
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
						product_subcategories s
					INNER JOIN
						products p
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
	
	//-------------------------------------------------------------------------------------------------
	// used in all methods in getting results from database(SELECT STATEMENTS)
	// should pass all values into $array_of_products.
	
	private function saveResults($results)
	{
		foreach($results as $result)
		{
			$product = new product();
	
			$product->__set('product_id', $result['product_id']);
			$product->__set('category_id', $result['category_id']);
			$product->__set('product_title', $result['product_title']);
			$product->__set('product_price', $result['product_price']);
			$product->__set('description', $result['description']);
			$product->__set('price', $result['product_price']);
			$product->__set('category_id', $result['category_id']);
			$product->__set('subcategory_id', $result['subcategory_id']);
			$product->__set('category_title', $result['category_title']);
			$product->__set('subcategory_title', $result['subcategory_title']);
			$product->__set('category_url', $result['category_url']);
			$product->__set('subcategory_url', $result['subcategory_url']);
				
			$image = new image();
			$image->__set('image_id', $result['image_id']);
			$image->selectFullPath();
				
				
			$product->__set('image_path', $image->__get('full_path'));
			$product->__set('permalink', $result['permalink']);
				
			$this->array_of_products[] = $product;
		}
	}
}