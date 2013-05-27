<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/Pagination/pagination.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'article.php';
require_once 'article_image.php';
require_once 'article_tags.php';

class articles
{
	private $array_of_articles = array();
	
	private $current_page;
	private $posts_per_page;
	private $pages;
	
	private $select_statement;
	private $has_body;
	
	public function __construct($has_body = FALSE)
	{
		$this->has_body = $has_body;
		
		$extra_field = '';
		
		if($this->has_body == TRUE) $extra_field = 'brief, approach, what_we_did ';
		
		$this->select_statement =
		"SELECT
			article_id,
			article_title,
			intro, {$extra_field}
			permalink,
			link_url,
			DATE_FORMAT(date_created, '%M %e, %Y') as date_posted
		FROM
			article a
		INNER JOIN
			routes r
		ON
			a.route_id = r.route_id
		";
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------

	public function select($is_live = FALSE, $has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = $this->select_statement;
			
			if($is_live == TRUE)
				$sql .= " AND status = 'published'";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
				$this->pages = $pagination->getNumberOfPages();
					
				$sql .= $pagination->getLimitClause();
			
				$pdo_statement = $pdo_connection->prepare($sql);
			}
			
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			$this->saveResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectByArchive($month, $year, $has_pagination = FALSE)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql =  $this->select_statement."
					AND
						DATE_FORMAT(date_created, '%m-%Y') = :archive_date
					AND
						status = 'published'";
			
			$archive_date = "{$month}-{$year}";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':archive_date', $archive_date, PDO::PARAM_STR);
			
			if($has_pagination == TRUE)
			{
				$pagination = new pagination($pdo_statement, $this->posts_per_page, $this->current_page);
				$this->pages = $pagination->getNumberOfPages();
					
				$sql .= $pagination->getLimitClause();
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':archive_date', $archive_date, PDO::PARAM_STR);
			}
			
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			$this->saveResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectOtherNews()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = $this->select_statement."
					AND
						status = 'published'
					ORDER BY
						RAND()
					LIMIT 0, 3";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			$this->saveResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectLatestNews()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = $this->select_statement."
					AND
						status = 'published'
					ORDER BY
						date_created DESC
					LIMIT 0,5";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			$this->saveResults($results);
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectArchivesList()
	{
		$array_of_archives = array();
		
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						DATE_FORMAT(date_created, '%M') as month_created,
						DATE_FORMAT(date_created, '%m') as month_number,
						DATE_FORMAT(date_created, '%Y') as year_created,
           				 count(date_created) as entries
					FROM
						article
					GROUP BY
						year_created, month_created
					ORDER BY
						date_created DESC";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
			
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll());
			
			foreach($results as $result)
			{
				$array_of_archives[] = array(
					'month'		=>$result['month_created'],
					'month_num'	=>$result['month_number'],
					'year'		=>$result['year_created'],
					'entries'	=>$result['entries']
				);
			}
			
			return $array_of_archives;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public function selectByDate()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = $this->select_statement."
					AND
						DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 30 DAY), '%Y-%m-%d') <= date_created
					AND
						status = 'published'
					ORDER BY
						date_created DESC
					LIMIT 0,15
						";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
				
			$results = resultCleaner::cleanResults($pdo_statement->fetchAll(PDO::FETCH_ASSOC));
			$this->saveResults($results);
	
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function selectCountAll()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "SELECT
						COUNT(article_id) as count
					FROM
						article";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->execute();
			
			$result = resultCleaner::cleanSingleResult($pdo_statement->fetch());
			
			return $result['count'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
// used in all methods in getting results from database(SELECT STATEMENTS)
// should pass all values into $array_of_articles.
	
	private function saveResults($results)
	{
		$this->array_of_articles = array();
		
		foreach($results as $result)
		{
			$article = new article();
		
			$article->__set('article_id', $result['article_id']);
			//$article->set('route_id', $result['route_id']);
			$article->__set('article_title', $result['article_title']);
			$article->__set('intro', $result['intro']);
			$article->__set('date_created', $result['date_posted']);
			$article->__set('link_url', $result['link_url']);
			
			if($this->has_body == TRUE){
				$article->__set('brief', $result['brief']);
				$article->__set('approach', $result['approach']);
				$article->__set('what_we_did', $result['what_we_did']);
			}
			
			$image = new article_image();
			$image->selectThumbnailByType($result['article_id'], 'gallery', TRUE);
			$image_path = $image->__get('full_path');
			
			$image_path = $image->__get('full_path');
			
			$article_tags = new article_tags();
			$article_tags->__set('article_id', $result['article_id']);
			$article_tags->select();
			
			$article->__set('image_path', $image_path);
			$article->__set('permalink', $result['permalink']);
			$article->__set('tags', $article_tags->__get('array_of_tags'));
			
			$this->array_of_articles[] = $article;
		}
	}
}
?>