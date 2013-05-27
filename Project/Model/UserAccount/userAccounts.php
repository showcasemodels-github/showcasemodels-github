<?php 

require_once FILE_ACCESS_CORE_CODE.'/Modules/Database/starfishDatabase.php';
require_once 'userAccount.php';

class userAccounts
{
	private $array_employers_account;
	private $user_role_id;
	
	
	/* ======================================================================================
	 * 
	 * 								GETTER METHODS
	 * 
	 * ======================================================================================
	 */
	public function getArrayEmployersAccount()
	{
		return $this->array_employers_account; 
	}
	
	/* ======================================================================================
	 * 
	 * 								SETTER METHODS
	 * 
	 * ======================================================================================
	 */
	
	public function setUserRoleId($user_role_id) {
		$this->user_role_id = $user_role_id;
	}
	
	/* ======================================================================================
	*
	* 								FUNCTIONS
	*
	* ======================================================================================
	*/
	
	// select by user role...
	public function selectByUserRole()
	{
		
		$pdo_connection = starfishDatabase::getConnection();
		
		$sql = "
					SELECT
						*
					FROM
						user_accounts
					WHERE
						user_role_id = :user_role_id
					";
		$pdo_statement = $pdo_connection->prepare($sql);
		$pdo_statement->bindParam(':user_role_id', $this->user_role_id, PDO::PARAM_INT);
		$pdo_statement->execute();
		
		
		$results = $pdo_statement->fetchAll();
		
		foreach($results as $result)
		{
			$user_account = new userAccount(); 
			
			$user_account->setUserAccountID($result['user_account_id']);
			$user_account->setUsername($result['username']);
			$user_account->setEmail($result['email']);
			
		
			$this->array_employers_account[] = $user_account;
		}
		
	}

	// ====================================================================================== //
	
}

?>