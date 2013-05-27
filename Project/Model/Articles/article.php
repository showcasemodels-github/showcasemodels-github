<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'article_image.php';

class article
{
	private $article_id;
	private $route_id;
	private $article_title;
	private $status;
	private $date_created;
	private $date_updated;
	private $permalink;
	
	private $category_id;
	private $subcategory_id;
	
	private $image_path;
	private $tags;
	private $unix_timestamp;
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------

	public static function checkIfExists($article_type, $article_title)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						COUNT(article_title) as count
					FROM
						article a
					WHERE
						article_title = :article_title
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_title', $article_title, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));
				
				return $result['count'];
	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectPrevOrNextPostPermalink($order)
	{
		$sign = '<';
		$orderby = 'DESC';
		
		if($order == 'next')
		{
			$sign = '>';
			$orderby = 'ASC';
		}
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						permalink
					FROM
						article a
					INNER JOIN
						routes r
					ON
						a.route_id = r.route_id	
					WHERE
						UNIX_TIMESTAMP(date_created) {$sign} {$this->unix_timestamp}
					AND
						article_id <> {$this->article_id}
					ORDER BY
						date_created {$orderby}
					LIMIT 0, 1
					";

				$pdo_statement = $pdo_connection->query($sql);
				//$pdo_statement->bindParam(':article_type', $this->article_type, PDO::PARAM_STR);
				//$pdo_statement->bindParam(':date_created', $this->date_created, PDO::PARAM_INT);
				//$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
				//$pdo_statement->execute();
			
				$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));

				return $result['permalink'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function select()
	{
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						article_id,
						a.route_id,
						article_title,
						status,
						permalink,
						DATE_FORMAT(date_created, '%M %e, %Y') as date_posted,
						UNIX_TIMESTAMP(date_created) as unix_posted
					FROM
						article a
					INNER JOIN
						routes r
					ON
						a.route_id = r.route_id	
					WHERE
					(
						article_id	= :article_id
					OR
						permalink	= :permalink
					)
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
				$pdo_statement->bindParam(':permalink', $this->permalink, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));

				$this->article_id		= $result['article_id'];
				$this->route_id			= $result['route_id'];
				$this->article_title	= $result['article_title'];
				$this->status			= $result['status'];
				$this->date_created		= $result['date_posted'];
				$this->unix_timestamp	= $result['unix_posted'];
				$this->permalink		= $result['permalink'];

				$article_image = new article_image();
				
				$image = $article_image->selectThumbnailByType($result['article_id'], 'gallery');
				$this->image_path = $article_image->__get('full_path');
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
							article_id,
							a.route_id,
							article_title,
							status,
							permalink,
							DATE_FORMAT(date_created, '%M %e, %Y') as date_posted
						FROM
							article a
						INNER JOIN
							routes r
						ON
							a.route_id = r.route_id	
						LIMIT 0,1";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
				
			$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));
	
			$this->article_id		= $result['article_id'];
			$this->route_id			= $result['route_id'];
			$this->article_title	= $result['article_title'];
			$this->status			= $result['status'];
			$this->date_created		= $result['date_posted'];
			$this->permalink		= $result['permalink'];

			$article_image = new article_image();
			
			$image = $article_image->selectThumbnailByType($result['article_id'], 'gallery');
			$this->image_path = $article_image->__get('full_path');
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
			
			$sql = "
					INSERT INTO
						`article`
						(
							`route_id`,
							`category_id`,
							`subcategory_id`,
							`article_title`,
							`intro`,
							`status`,
							`date_created`
						)
						VALUES
						(
							:route_id,
							:category_id,
							:subcategory_id,
							:article_title,
							:intro,
							'unpublished',
							NOW()
						)
					";
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':route_id', $this->route_id, PDO::PARAM_INT);
				$pdo_statement->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
				$pdo_statement->bindParam(':subcategory_id', $this->subcategory_id, PDO::PARAM_INT);
				$pdo_statement->bindParam(':article_title', $this->article_title, PDO::PARAM_STR);
				$pdo_statement->bindParam(':intro', $this->intro, PDO::PARAM_STR);
				$pdo_statement->execute();
				
				$this->article_id = $pdo_connection->lastInsertId();
				
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
			
			$sql = "
					UPDATE
						article
					SET
						`article_title`	= :article_title,
						`status`		= :status,
						`date_updated`	= NOW()
					WHERE
						`article_id`	= :article_id
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_title', $this->article_title, PDO::PARAM_STR);
				$pdo_statement->bindParam(':status', $this->status, PDO::PARAM_INT);
				$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
				$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public static function delete($article_id)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "DELETE FROM
						article
					WHERE
						article_id = :article_id
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
				$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
}