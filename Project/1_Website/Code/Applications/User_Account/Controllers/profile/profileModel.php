<?php 

require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class profileModel
{ 
	private $user_id;
	private $user_info = array();
	
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
	
	public function select_user()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						email
					FROM
						customers
					WHERE
						user_id = :user_id";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':user_id', $this->user_id, PDO::PARAM_STR);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
				
			$this->user_info[] = $result;
			
			$this->selectShiptoInfo();
			$this->selectBilltoInfo();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function selectShiptoInfo()
	{
		try
		{
			$pdo_connection = starfishDatabase::getConnection();
	
			$sql = "SELECT
						firstname,
						lastname,
						address,
						address_2,
						city,
						state,
						other_state,
						zipcode,
						country,
						phonenumber,
						faxnumber,
						company
					FROM
						shipto
					WHERE
						user_id = :user_id";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':user_id', $this->user_id, PDO::PARAM_STR);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
	
			$this->user_info[] = $result;
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	
	}
	
//-------------------------------------------------------------------------------------------------
	
public function selectBilltoInfo()
	{
	try
		{
			$pdo_connection = starfishDatabase::getConnection();
		
			$sql = "SELECT
						firstname,
						lastname,
						address,
						address_2,
						city,
						state,
						other_state,
						zipcode,
						country,
						phonenumber,
						faxnumber,
						company
					FROM
						billto
					WHERE
						user_id = :user_id";
			
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':user_id', $this->user_id, PDO::PARAM_STR);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
		
			$this->user_info[] = $result;
		}
		catch(PDOException $pdoe)
		{
		throw new Exception($pdoe);
		}
	}
}
?>