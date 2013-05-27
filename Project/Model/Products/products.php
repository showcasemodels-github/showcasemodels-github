<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'product.php';
require_once 'Project/Model/Pagination/pagination.php';
require_once 'Project/Model/Products/product_images.php';

class products
{
	private $array_of_products = array();
	private $array_of_random_products = array();
	private $product_id;
	private $product_title;
	private $category_id;
	private $category_url;
	private $subcategory_url;
	private $subcategory_id;
	private $product_price;
	private $offset_value;
	private $posts_per_page;
	private $permalink;
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

	public function select($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						p.product_id,
						p.route_id,
						p.category_id,
						subcategory_id,
						product_title,
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
						p.route_id = r.route_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
				$this->pages = $pagination->getNumberOfPages();
					
				$sql .= $pagination->getLimitClause();
			
				$pdo_statement = $pdo_connection->prepare($sql);
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

//-------------------------------------------------------------------------------------------------
	
	public function searchProducts($keyword , $has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();

			$sql = "SELECT
								p.product_id,
								p.route_id,
								p.category_id,
								s.subcategory_id,
								product_title,
								c.category_url,
								s.subcategory_url,
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
								product_categories c
							ON
								c.category_id = p.category_id
							LEFT JOIN
								product_subcategories s
							ON
								s.subcategory_id = p.subcategory_id
							";
			
			if(empty($keyword)) 
			{ 
				$this->array_of_products = NULL;
			}
			else 
			{
				$sql .= " WHERE
								product_title LIKE '%".trim($keyword)."%' 
						";
				
				$pdo_statement = $pdo_connection->prepare($sql);
					
				if($has_pagination == TRUE)
				{
					$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
					$this->pages = $pagination->getNumberOfPages();
						
					$sql .= $pagination->getLimitClause();
						
					$pdo_statement = $pdo_connection->prepare($sql);
				}
					
				$pdo_statement->execute();
				$results = $pdo_statement->fetchAll(); 
				$this->saveResults($results);
			}	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
//-------------------------------------------------------------------------------------------------

	public function selectByCategoryID($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						*
					FROM
						products p
					LEFT JOIN
						route r
					ON
						p.route_id = r.route_id
					WHERE
						category_id = :category_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
				$this->pages = $pagination->getNumberOfPages();
					
				$sql .= $pagination->getLimitClause();
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
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
	
	
//-------------------------------------------------------------------------------------------------

	public function selectBySubCategoryID($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						*
					FROM
						products p
					LEFT JOIN
						route r
					ON
						p.route_id = r.route_id
					WHERE
						subcategory_id = :subcategory_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
				$this->pages = $pagination->getNumberOfPages();
					
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
	
//-------------------------------------------------------------------------------------------------
	
	public function selectRandomRelatedProducts($has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
									p.product_id,
									p.route_id,
									p.category_id,
									subcategory_id,
									product_title,
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
								WHERE
									category_id = :category_id
								ORDER BY
									RAND() LIMIT 0,3";
	
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
	
	public function selectRandomRelatedProductsByCategory($has_pagination = FALSE)
	{ 
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
										p.product_id,
										p.route_id,
										p.category_id,
										subcategory_id,
										product_title,
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
									WHERE
										category_id = :category_id AND
										subcategory_id IS NULL 
									ORDER BY
										RAND() LIMIT 0,3";
	
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
			$product->__set('product_title', $result['product_title']);
			$product->__set('product_price', $result['product_price']);
			$product->__set('description', $result['description']);
			$product->__set('price', $result['product_price']);
			$product->__set('category_id', $result['category_id']);
			$product->__set('subcategory_id', $result['subcategory_id']);
			
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
	
	private function saveRandomResults($results)
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
						
						$image = new image();
			$image->__set('image_id', $result['image_id']);
						$image->selectFullPath();
				
				
			$product->__set('image_path', $image->__get('full_path'));
			$product->__set('permalink', $result['permalink']);
				
			$this->array_of_random_products[] = $product;
		} 
	} 
}
?>