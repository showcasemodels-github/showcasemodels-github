<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'article_tag.php';

class article_tags
{
	private $article_id;
	private $array_of_tags = array();
	
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
					$this->array_of_tags[] = $result['tag'];
		}
		catch (PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}
?>