<?
require_once 'Project/ApplicationsFramework/MVC_superClasses/applicationsSuperController.php';
//require_once 'Project/Code/System/Accounts/userAddresses/userAddress.php';
//require_once 'Project/Code/System/Accounts/userAddresses/userAddresses.php';
require_once 'Project/Model/UserAccount/userAccount.php';

class user_accountAjaxController extends applicationsSuperController
{
	
	public function edit_fieldAction()
	{
		$address_id = $_REQUEST['address_id'];
		$address_type = $_REQUEST['address_type'];
		$column = $_REQUEST['column_name'];
		$value = $_REQUEST['new_value'];
		
		$user_address = new userAddress();
		$user_address->setAddressType($address_type);
		$user_address->setAddressID($address_id);
		$user_address->update_field($column, $value);
		
		
		if($column == 'country')
		{
			require_once 'Project/Code/ApplicationsFramework/MVC_superClasses/applicationsSuperView.php';
			$view = new applicationsSuperView();
			$countries = $view->getCountryOptions();
			
			jQuery::addMessage($countries[$value]);
		}
		else
			jQuery::addMessage('');
		
		jQuery::getResponse();
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function edit_profileAction()
	{
		$user_account_id = authorization::getUserSession()->user_account_id;
		$column = $_REQUEST['column_name'];
		
		if($column == "password") $value = sha1(md5($_REQUEST['new_value']));
		else $value = $_REQUEST['new_value'];
		
		$user_account = new userAccount();
		$user_account->setUserAccountID($user_account_id);
		$user_account->set_field($column, $value);
	
		jQuery::getResponse();
	}
//-------------------------------------------------------------------------------------------------	
	public function check_emailAction()
	{
		if(userAccount::checkEmailIfExists($_REQUEST['email']) == TRUE)
			jQuery::addMessage('exists');
		else 	
			jQuery::addMessage('notexists');
		
		jQuery::getResponse();
	}
//-------------------------------------------------------------------------------------------------	
	
	public function show_addressesAction()
	{
		$user_account_id = authorization::getUserSession()->user_account_id;
		$address_type = $_REQUEST['address_type'];
		
		$user_addresses = new userAddresses();
		$user_addresses->setAddressType($address_type);
		$user_addresses->setUserAccountID($user_account_id);
		$addresses = $user_addresses->selectAddresses();
		
		$content = '<ul id="selection-list">';
		foreach ($addresses as $address){
			$content .= '<li><input type="radio" name="addressSelect" value="'.$address->getAddressID().'">'.$address->getAddress().'</li>';
		}
		$content .= '</ul>';
		 
		jQuery('.'.$address_type.'_selector')->prepend($content);
		jQuery::getResponse();
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function select_addressAction()
	{
		$user_account_id = authorization::getUserSession()->user_account_id;
		$address_id = $_REQUEST['address_id'];
		
		$user_address = new userAddress();
		$user_address->setAddressID($address_id);
		$user_address->select();
		
		$user_address->setUserAccountID($user_account_id);
		$user_address->resetDefault('default_'.$user_address->getAddressType());
		$user_address->setDefault('default_'.$user_address->getAddressType());
		
		jQuery('#'.$user_address->getAddressType().'_completeAddress')->text($user_address->getAddress().', '.$user_address->getCity().', '.$user_address->getState().', '.$user_address->getCountry());
		jQuery('#'.$user_address->getAddressType().'_phone')->text($user_address->getPhone());
		jQuery::getResponse();
	}
	
//-------------------------------------------------------------------------------------------------	
	
	public function forgotPasswordAction()
	{
		$user_account = new userAccount();
		$exists = $user_account->checkEmail($_REQUEST['email']);
		
		if($exists !== FALSE)
		{
			require_once 'Project/Code/1_Website/Applications/User_Account/Modules/Mailer/mailer.php';
			$mailer = new mailer();
			
			$string = $this->genRandomString();
			
			$mailer->send_email($exists['first_name'].' '.$exists['last_name'],
								$exists['email'],
								'Your New Password!!',
								$string);

			$user_account->setUserAccountID($exists['user_account_id']);
			$user_account->set_field('password', sha1(md5($string)));
			
			jQuery::addMessage('True');
		}
		elseif($exists == FALSE)
			jQuery::addMessage('False');
		
		jQuery::getResponse();
	}
	
//=================================================================================================
	
	private function genRandomString() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';
	
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}
}