<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'Project/Model/Products/product.php';
require_once 'Project/Model/Pagination/pagination.php';
require_once 'Project/Model/Products/product_images.php';

class productsBlockModel
{
	private $array_of_products = array();
	private $array_of_categories = array();
	private $array_of_subcategories = array();
	private $category_id;
	
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
	
	public function selectCategories()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						category_id,
						parent_id,
						category_name,
						category_url
					FROM
						product_categories
					WHERE 
						parent_id IS NULL";
				
			$pdo_statement = $pdo_connection->query($sql);
			$results = $pdo_statement->fetchAll();
	
			$this->array_of_categories = $results;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function selectCategoriesWithParent()
	{
	try
		{
			$pdo_connection = starfishDatabase::getConnection();
		
			$sql = "SELECT
						category_id,
						category_name,
						category_url
					FROM
						product_categories
					WHERE
						parent_id = :parent_id";
						
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(":parent_id", $this->category_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			$results = $pdo_statement->fetchAll();
		
			$this->array_of_subcategories = $results;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectFeaturedProducts($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						p.product_id,
						product_name,
						description,
						pricing,
						product_image_id,
						image_id
					FROM	
						products p
					LEFT JOIN
						product_images pi
					ON
						pi.product_id = p.product_id
					WHERE
						is_featured = 1";
	
			$pdo_statement = $pdo_connection->prepare($sql);
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
//used in all methods in getting results from database(SELECT STATEMENTS)
//should pass all values into $array_of_products.
	
	private function saveResults($results)
	{
		foreach($results as $result)
		{
			$product = new product();
				
			$product->__set('product_id', $result['product_id']);
			$product->__set('product_name', $result['product_name']);
			$product->__set('pricing', $result['pricing']);
			$product->__set('description', $result['description']);
			$product->__set('price', $result['pricing']);
				
				
			$image = new image();
			$image->__set('image_id', $result['image_id']);
			$image->selectFullPath();
				
				
			$product->__set('image_path', $image->__get('full_path'));
				
			$this->array_of_products[] = $product;
		}
	}
}
?>