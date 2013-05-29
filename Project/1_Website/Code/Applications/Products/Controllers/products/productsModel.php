<?php
require_once(FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/viewSuperClass_Core/viewSuperClass_Core.php');
require_once 'Project/Model/Products/product.php';
require_once 'Project/Model/Pagination/pagination.php';
require_once 'Project/Model/Products/product_images.php';

class productsModel extends viewSuperClass_Core
{
	private $is_product = '';
	private $array_of_products = array();
	private $array_of_random_products = array();
	private $array_of_subcategories = array();
	
	private $product_id;
	private $product_name;
	private $description;
	private $category_name;
	private $category_url;
	private $category_id;
	private $pricing;
	private $product_image_id;
	private $image_id;
	private $permalink;
	
//-------------------------------------------------------------------------------------------------
	
	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
	
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function __set($field, $value) {
		if(property_exists($this, $field)) $this->{$field} = $value;
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function checkIfProduct($product_name)
	{
	try
		{
		$pdo_connection = starfishDatabase::getConnection();
	
		$sql = "SELECT
						*
				FROM
					products
				WHERE
					product_name = :product_name AND
					is_published = 1";

		$pdo_statement = $pdo_connection->prepare($sql);
		$pdo_statement->bindParam(':product_name', $product_name);
		$pdo_statement->execute();
		$results = $pdo_statement->fetchAll();
		
		if(count($results) == 0)
		{
			$this->is_product = 0;	
		}
		else 
		{
			$this->is_product = 1;
		}
		}
		catch(PDOException $pdoe)
		{
		throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectName($permalink)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						category_name
					FROM
						product_categories pc
					INNER JOIN
						route r
					ON
						r.route_id = pc.route_id
					WHERE
						permalink = :permalink
			";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $permalink);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
			$this->category_name = $results;
	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}	

//-------------------------------------------------------------------------------------------------
	
	public function selectDescription($permalink)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
							description
						FROM
							product_categories pc
						INNER JOIN
							route r
						ON
							r.route_id = pc.route_id
						WHERE
							permalink = :permalink";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $permalink);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
			$this->description = $results;
	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
//-------------------------------------------------------------------------------------------------
	
	public function getCategoryID()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						category_id
					FROM
						product_categories pc
					INNER JOIN
						route r
					ON
						r.route_id = pc.route_id
					WHERE
						permalink = :permalink";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $this->permalink, PDO::PARAM_STR);
	
			$pdo_statement->execute();
			$results = $pdo_statement->fetch();
			$this->category_id = $results[0];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectSubcategories()
	{
	try
		{
		$pdo_connection = starfishDatabase::getConnection();
	
		$sql = "SELECT 
					category_name,
					permalink
				FROM 
					product_categories pc
				INNER JOIN
					route r
				ON
					r.route_id = pc.route_id
				WHERE
					parent_id = :category_id";
		
		$pdo_statement = $pdo_connection->prepare($sql);
		$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_STR);
	
		$pdo_statement->execute();
		$results = $pdo_statement->fetchAll();
		$this->array_of_subcategories = $results;
		//echo "<pre>";var_dump($this->array_of_subcategories);die;
		}
		catch(PDOException $pdoe)
		{
		throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function getSubcategoryName()
	{
		try
			{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						category_name
					FROM 
						product_categories pc
					INNER JOIN
						route r
					ON
						r.route_id = pc.route_id
					WHERE
						permalink = :permalink";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $this->permalink, PDO::PARAM_STR);
	
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
			$this->category_name = $results;
			//echo "<pre>";var_dump($this->array_of_subcategories);die;
			}
			catch(PDOException $pdoe)
			{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function getSubcategoryDescription()
	{
	try
		{
		$pdo_connection = starfishDatabase::getConnection();
	
		$sql = "SELECT
					description
				FROM 
					product_categories pc
				INNER JOIN
					route r
				ON
					r.route_id = pc.route_id
				WHERE
					permalink = :permalink";
				
		$pdo_statement = $pdo_connection->prepare($sql);
		$pdo_statement->bindParam(':permalink', $this->permalink, PDO::PARAM_STR);
	
		$pdo_statement->execute();
		$results = $pdo_statement->fetchAll();
		$this->description = $results;
		//echo "<pre>";var_dump($this->array_of_subcategories);die;
		}
		catch(PDOException $pdoe)
		{
		throw new Exception($pdoe);
		}
		}
//-------------------------------------------------------------------------------------------------
	
	public function selectProduct($has_pagination = FALSE)
	{
		try
		{ 
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
							p.product_id,
							product_name,
							p.description,
							category_name,
							category_url,
							pcl.category_id,
							pricing,
							product_image_id,
							image_id,
							permalink
						FROM
							products p		
						LEFT JOIN
							route r
						ON
							r.route_id = p.route_id
						LEFT JOIN
							product_images pi
						ON
							pi.product_id = p.product_id	
						LEFT JOIN	
							product_categories_lookup pcl
						ON
							p.product_id = pcl.product_id
						LEFT JOIN 
							product_categories pc
						ON
							pcl.category_id = pc.category_id
						WHERE
							p.product_id  = :product_id AND
							is_published = 1";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':product_id', $this->product_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));

			$this->product_id		= $result['product_id'];
			$this->product_name		= $result['product_name'];
			$this->category_name	= $result['category_name'];
			$this->category_url		= $result['category_url'];
			$this->category_id		= $result['category_id'];
			$this->description		= $result['description'];
			$this->pricing			= $result['pricing'];
			$this->permalink		= $result['permalink'];
			
			$product_image = new product_image();
			
			$image = $product_image->selectThumbnailByType($result['product_id'], 'gallery');
			$this->image_path = $product_image->__get('full_path');
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectProducts($has_pagination = FALSE)
	{ 
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						p.product_id,
						product_name,
						p.description,
						category_name,
						pcl.category_id,
						pricing,
						product_image_id,
						image_id,
						permalink
					FROM
						products p		
					LEFT JOIN
						route r
					ON
						r.route_id = p.route_id
					LEFT JOIN
						product_images pi
					ON
						pi.product_id = p.product_id	
					LEFT JOIN	
						product_categories_lookup pcl
					ON
						p.product_id = pcl.product_id
					LEFT JOIN 
						product_categories pc
					ON
						pcl.category_id = pc.category_id
					WHERE
						pcl.category_id  = :category_id AND
						is_published = 1";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll(); 
			$this->saveResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}

//-------------------------------------------------------------------------------------------------
	
	public function getSubCategoryID()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						category_id
					FROM
						product_categories	pc
					INNER JOIN				
						route r
					ON
						r.route_id = pc.route_id	
					WHERE
						permalink = :permalink";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $this->permalink, PDO::PARAM_STR);
			$pdo_statement->execute();
			$results = $pdo_statement->fetch();
			$this->category_id = $results[0];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function getProductCategoryID($permalink)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT 
						category_id
					FROM
						products p
					INNER JOIN
						route r
					ON
						r.route_id = p.route_id
					INNER JOIN
						product_categories_lookup pcl
					ON
						p.product_id = pcl.product_id
					WHERE
						permalink = :permalink AND
						is_published = 1";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':permalink', $permalink, PDO::PARAM_STR);
			$pdo_statement->execute();
			$results = $pdo_statement->fetch();
			$this->category_id = $results['category_id']; 
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectRandomRelatedProducts($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						p.product_id,
						product_name,
						p.description,
						pcl.category_id,
						category_name,
						pricing,
						product_image_id,
						image_id,
						permalink
					FROM
						products p		
					LEFT JOIN
						route r
					ON
						r.route_id = p.route_id
					LEFT JOIN
						product_images pi
					ON
						pi.product_id = p.product_id	
					LEFT JOIN	
						product_categories_lookup pcl
					ON
						p.product_id = pcl.product_id
					LEFT JOIN 
						product_categories pc
					ON
						pcl.category_id = pc.category_id
					WHERE
						pcl.category_id = :category_id AND
						is_published = 1
					ORDER BY
						RAND() LIMIT 0,4";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
			$this->saveRandomResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectRelatedProductsSameParentID($has_pagination = FALSE)
	{
	try
		{
		$pdo_connection = starfishDatabase::getConnection();
	
		$sql = "SELECT
							p.product_id,
							product_name,
							p.description,
							product_url,
							pcl.category_id,
							category_name,
							category_url,
							pricing,
							product_image_id,
							image_id,
							permalink
						FROM
							products p		
						LEFT JOIN
							route r
						ON
							r.route_id = p.route_id
						LEFT JOIN
							product_images pi
						ON
							pi.product_id = p.product_id	
						LEFT JOIN	
							product_categories_lookup pcl
						ON
							p.product_id = pcl.product_id
						LEFT JOIN 
							product_categories pc
						ON
							pcl.category_id = pc.category_id
						WHERE
							pcl.category_id = :category_id AND
							is_published = 1
						ORDER BY
							RAND() LIMIT 0,4";
		
				$pdo_statement = $pdo_connection->prepare($sql);
		$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
		$pdo_statement->execute();
		$results = $pdo_statement->fetchAll();
		$this->saveRandomResults($results);
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
			$product->__set('product_name', $result['product_name']);
			$product->__set('pricing', $result['pricing']);
			$product->__set('description', $result['description']);
			$product->__set('price', $result['pricing']);
			$product->__set('category_id', $result['category_id']);
			$product->__set('permalink', $result['permalink']);
				
			$image = new image();
			$image->__set('image_id', $result['image_id']);
			$image->selectFullPath();
				
				
			$product->__set('image_path', $image->__get('full_path'));
				
			$this->array_of_products[] = $product;
		}
	}
	
	
	private function saveRandomResults($results)
	{
		foreach($results as $result)
		{
			$product = new product();
			
			$product->__set('product_id', $result['product_id']);
						$product->__set('category_id', $result['category_id']);
						$product->__set('product_name', $result['product_name']);
						$product->__set('pricing', $result['pricing']);
						$product->__set('description', $result['description']);
						$product->__set('pricing', $result['pricing']);
						$product->__set('category_id', $result['category_id']);
						$product->__set('category_name', $result['category_name']);
				
			$image = new image();
			$image->__set('image_id', $result['image_id']);
			$image->selectFullPath();
			
			
			$product->__set('image_path', $image->__get('full_path'));
			$product->__set('permalink', $result['permalink']);
				
			$this->array_of_random_products[] = $product;
		}
	}
}