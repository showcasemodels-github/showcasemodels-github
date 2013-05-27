<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/ResultCleaner/resultCleaner.php';
require_once 'article_element.php';

class articleElements
{
	private $array_of_article_elements;
	
	public function getArrayOfArticleElements()
	{
		if ($this->array_of_article_elements != null)
			return $this->array_of_article_elements;
		else
			return false;		
	}
	
	public function select($article_id)
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
			$pdo_statement->bindParam(':article_id', $article_id, PDO::PARAM_INT);
			$pdo_statement->execute();
				
			$results = $pdo_statement->fetchAll(PDO::FETCH_OBJ);

			foreach ($results as $result)
			{
				$article_element = new articleElement();
				
				$article_element->setArticleId($result->article_id);
				$article_element->setArticleElementId($result->article_element_id);
				$article_element->setArticleElementContent($result->article_element_content);
				$article_element->setArticleElementType($result->article_element_type);
				$article_element->setArticleElementPosition($result->article_element_position);
				
				$this->array_of_article_elements[] = $article_element;
			}
			
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}