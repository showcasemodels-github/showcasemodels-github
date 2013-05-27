<?php 
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class loginModel 
{ 
	private $user_account_id;
	private $username;
	private $password;
	
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
	
	public function login()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
			$sql = "SELECT
							user_id
						FROM
							customers
						WHERE
							username = :username
						AND
							password = :password
						";
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':username', $this->username, PDO::PARAM_STR);
			$pdo_statement->bindParam(':password', $this->password, PDO::PARAM_STR);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
				
			$this->user_account_id	= $result['user_id'];
	
			if($result !== FALSE) 
			{
			return TRUE;
			}
			else 
			{
			return FALSE;
			} 
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}