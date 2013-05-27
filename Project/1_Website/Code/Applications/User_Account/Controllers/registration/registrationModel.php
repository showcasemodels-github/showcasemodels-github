<?php
require_once FILE_ACCESS_CORE_CODE.'/Framework/MVC_superClasses_Core/modelSuperClass_Core/modelSuperClass_Core.php';
require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';

class registrationModel extends modelSuperClass_Core
{
	private $user_id;
	private $username;
	private $password;
	private $email;
	
	private $shiptoFirstname;
	private $shiptoLastname;
	private $shiptoAddress;
	private $shiptoAddress_2;
	private $shiptoCountry;
	private $shiptoPhone;
	private $shiptoFax;
	private $shiptoCompany;
	private $shiptoCity;
	private $shiptoState;
	private $shiptoOther_state;
	private $shiptoZipcode;
	
	private $billtoFirstname;
	private $billtoLastname;
	private $billtoAddress;
	private $billtoAddress_2;
	private $billtoCountry;
	private $billtoPhone;
	private $billtoFax;
	private $billtoCompany;
	private $billtoCity;
	private $billtoState;
	private $billtoOther_state;
	private $billtoZipcode;
	
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
	
	public function insertCustomer()
	{
		try{
			$pdo_connection = starfishDatabase::getConnection();
			$sql = "INSERT INTO
						customers
						(
						`email`,
						`username`,
						`password`
						)
					VALUES
						(
						:email,
						:username,
						:password
						)";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':email', $this->email, PDO::PARAM_STR);
			$pdo_statement->bindParam(':username', $this->username, PDO::PARAM_STR);
			$pdo_statement->bindParam(':password', $this->password, PDO::PARAM_STR);
			$pdo_statement->execute();
			
			$this->getCustomerID();
			$this->insertToShipto();
			$this->insertToBillto();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
//-------------------------------------------------------------------------------------------------
	
	public function getCustomerID()
	{
		try{
			$pdo_connection = starfishDatabase::getConnection();
			$sql = "SELECT
						user_id
					FROM
						customers
					WHERE
						username = :username AND
						password = :password AND
						email = :email";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':email', $this->email, PDO::PARAM_STR);
			$pdo_statement->bindParam(':username', $this->username, PDO::PARAM_STR);
			$pdo_statement->bindParam(':password', $this->password, PDO::PARAM_STR);
			$pdo_statement->execute();
			$result = $pdo_statement->fetch();
			$this->user_id = $result['user_id'];
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function insertToShipto()
	{
		try{
			$pdo_connection = starfishDatabase::getConnection();
			$sql = "INSERT INTO
						shipto
						(
						`user_id`,
						`firstname`,
						`lastname`,
						`address`,
						`address_2`,
						`city`,
						`state`,
						`other_state`,
						`zipcode`,
						`country`,
						`phonenumber`,
						`faxnumber`,
						`company`
						)
					VALUES
						(
						:user_id,
						:firstname,
						:lastname,
						:address,
						:address_2,
						:city,
						:state,
						:other_state,
						:zipcode,
						:country,
						:phonenumber,
						:faxnumber,
						:company
						)";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':firstname', $this->shiptoFirstname, PDO::PARAM_STR);
			$pdo_statement->bindParam(':lastname', $this->shiptoLastname, PDO::PARAM_STR);
			$pdo_statement->bindParam(':address', $this->shiptoAddress, PDO::PARAM_STR);
			$pdo_statement->bindParam(':address_2', $this->shiptoAddress_2, PDO::PARAM_STR);
			$pdo_statement->bindParam(':city', $this->shiptoCity, PDO::PARAM_STR);
			$pdo_statement->bindParam(':state', $this->shiptoState, PDO::PARAM_STR);
			$pdo_statement->bindParam(':other_state', $this->shiptoOther_state, PDO::PARAM_STR);
			$pdo_statement->bindParam(':zipcode', $this->shiptoZipcode, PDO::PARAM_STR);
			$pdo_statement->bindParam(':country', $this->shiptoCountry, PDO::PARAM_STR);
			$pdo_statement->bindParam(':phonenumber', $this->shiptoPhone, PDO::PARAM_STR);
			$pdo_statement->bindParam(':faxnumber', $this->shiptoFax, PDO::PARAM_STR);
			$pdo_statement->bindParam(':company', $this->shiptoCompany, PDO::PARAM_STR);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
	
//-------------------------------------------------------------------------------------------------
	
	public function insertToBillto()
	{
		try{
			$pdo_connection = starfishDatabase::getConnection();
			$sql = "INSERT INTO
						billto
						(
						`user_id`,
						`firstname`,
						`lastname`,
						`address`,
						`address_2`,
						`city`,
						`state`,
						`other_state`,
						`zipcode`,
						`country`,
						`phonenumber`,
						`faxnumber`,
						`company`
						)
					VALUES
						(
						:user_id,
						:firstname,
						:lastname,
						:address,
						:address_2,
						:city,
						:state,
						:other_state,
						:zipcode,
						:country,
						:phonenumber,
						:faxnumber,
						:company
						)";
	
			$pdo_statement = $pdo_connection->prepare($sql);
			$pdo_statement->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
			$pdo_statement->bindParam(':firstname', $this->billtoFirstname, PDO::PARAM_STR);
			$pdo_statement->bindParam(':lastname', $this->billtoLastname, PDO::PARAM_STR);
			$pdo_statement->bindParam(':address', $this->billtoAddress, PDO::PARAM_STR);
			$pdo_statement->bindParam(':address_2', $this->billtoAddress_2, PDO::PARAM_STR);
			$pdo_statement->bindParam(':city', $this->billtoCity, PDO::PARAM_STR);
			$pdo_statement->bindParam(':state', $this->billtoState, PDO::PARAM_STR);
			$pdo_statement->bindParam(':other_state', $this->billtoOther_state, PDO::PARAM_STR);
			$pdo_statement->bindParam(':zipcode', $this->billtoZipcode, PDO::PARAM_STR);
			$pdo_statement->bindParam(':country', $this->billtoCountry, PDO::PARAM_STR);
			$pdo_statement->bindParam(':phonenumber', $this->billtoPhone, PDO::PARAM_STR);
			$pdo_statement->bindParam(':faxnumber', $this->billtoFax, PDO::PARAM_STR);
			$pdo_statement->bindParam(':company', $this->billtoCompany, PDO::PARAM_STR);
			$pdo_statement->execute();
		}
		catch(PDOException $pdoe)
		{
			throw new Exception($pdoe);
		}
	}
}