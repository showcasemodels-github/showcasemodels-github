<?php 
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';

class article_tag
{
	private $article_id;
	private $tag;
	
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
						tag
					FROM
						article_tags
					WHERE
						article_id = :article_id
					";
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
				$pdo_statement->execute();
			
				$results = resultCleaner::cleanResults($pdo_statement->fetchAll(PDO::FETCH_ASSOC));
				
				foreach ($results as $result)
					$this->tag[] = $result['tag'];
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function checkIfExists($article_id, $tag)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "SELECT
						COUNT(tag) as count
					FROM
						article_tags
					WHERE
						article_id	= :article_id
					AND
						tag			= :tag
					";
				
				$pdo_statement = $pdo_connection->prepare($sql);
				$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_STR);
				$pdo_statement->bindParam(':tag', $tag, PDO::PARAM_STR);
				$pdo_statement->execute();
			
				$result = resultCleaner::cleanSingleResult($pdo_statement->fetch(PDO::FETCH_ASSOC));
				
				return $result['count'];
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function delete($article_id, $tag)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "DELETE FROM
						article_tags
					WHERE
						article_id	= :article_id
					AND
						tag			= :tag
					";

			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':tag', $tag, PDO::PARAM_STR);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------

	public static function insert($article_id, $tag)
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
				
			$sql = "INSERT INTO
						article_tags
						(
							article_id,
							tag
						)
					VALUES
						(
							:article_id,
							:tag
						)
					";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':tag', $tag, PDO::PARAM_STR);
			$pdo_statement->execute();
				
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}
?>