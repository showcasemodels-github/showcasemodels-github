<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'article_elements.php';

class articleElement extends articleElements
{
	private $article_element_id;
	private $article_id;
	private $article_element_content;
	private $article_element_type;
	private $article_element_position;

//-------------------------------------------------------------------------------------------------	

	public function __get($field)
	{
		if(property_exists($this, $field)) return $this->{$field};
		
		else return NULL;
	}
	
//-------------------------------------------------------------------------------------------------	

	public function __set($field, $value) { if(property_exists($this, $field)) $this->{$field} = $value; }
	
//-------------------------------------------------------------------------------------------------

	public function setArticleElementId($value)
	{
		$this->article_element_id = $value;
	}
	
	public function getArticleElementId()
	{
		if ($this->article_element_id != null)
			return $this->article_element_id;
		else
			return false;
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function setArticleId($value)
	{
		$this->article_id = $value;
	}
	
	public function getArticleId()
	{
		if ($this->article_id != null)
			return $this->article_id;
		else
			return false;
	}
	
//-------------------------------------------------------------------------------------------------

	public function setArticleElementContent($value)
	{
		$this->article_element_content = $value;
	}
	
	public function getArticleElementContent()
	{
		if ($this->article_element_content != null)
			return $this->article_element_content;
		else
			return false;
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function setArticleElementType($value)
	{
		$this->article_element_type = $value;
	}
	
	public function getArticleElementType()
	{
		if ($this->article_element_type != null)
			return $this->article_element_type;
		else
			return false;
	}
	
	public function setArticleElementPosition($value)
	{
		$this->article_element_position = $value;
	}
	
	public function getArticleElementPosition()
	{
		if ($this->article_element_position != null)
			return $this->article_element_position;
		else
			return false;
	}
	
//-------------------------------------------------------------------------------------------------

	public function update()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "
					UPDATE
						article_elements
					SET
						`article_element_content`	= :article_element_content,
						`article_element_type`		= :article_element_type,
						`article_element_position`	= :article_element_position
					WHERE
						`article_element_id`	= :article_element_id
					";
				
			$pdo_statement = $pdo_connection->prepare($sql);
			
			$pdo_statement->bindParam(':article_element_content', $this->article_element_content, PDO::PARAM_STR);
			$pdo_statement->bindParam(':article_element_type', $this->article_element_type, PDO::PARAM_STR);
			$pdo_statement->bindParam(':article_element_position', $this->article_element_position, PDO::PARAM_STR);
			$pdo_statement->bindParam(':article_element_id', $this->article_element_id, PDO::PARAM_INT);
			
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
	public function delete()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "DELETE FROM
									article_elements
								WHERE
									article_id = :article_id
								";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
	public function insert()
	{
	try
		{
			$pdo_connection = starfishDatabase::getConnection();
			
			$sql = "
					INSERT INTO
						`article_elements`
						(
							`article_element_content`,
							`article_element_type`,
							`article_id`
						)
						VALUES
						(
							:article_element_content,
							:article_element_type,
							:article_id
						)
					";
			
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_element_content', $this->article_element_content, PDO::PARAM_STR);
				$pdo_statement->bindParam(':article_element_type', $this->article_element_type, PDO::PARAM_STR);
				$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
				
				$pdo_statement->execute();
				
				$this->article_element_id = $pdo_connection->lastInsertId();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);	
		}
	}
	
	public function select()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT * FROM
							`article_elements`
						WHERE
							article_id = :article_id
								";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':article_id', $This->article_id, PDO::PARAM_INT);
			$pdo_statement->execute();
			
			$result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
			
			$this->article_element_content = $result['article_element_content'];
			$this->article_element_type = $result['article_element_type'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}

}