<?php
require_once FILE_ACCESS_CORE_CODE.'/Modules/Authorization/authorization.php';

class user_accountBlockController 
{
	public function show_account_panel()
	{
		$content ='';
		//$content .= $this->showLogInLinkIfLoggedOut();	
		$content .= $this->showLogOutLinkIfLoggedIn();
		
		return $content;
	}
	
	
	
	//===================================================================================================================================
	private function showLogOutLinkIfLoggedIn()
	{
		if (true==authorization::areWeLoggedIn())
		{
			$cleanpath = $this->cleanPath(routes::getInstance()->getWholePath());
			/* return '<a title="Leaving so soon!" href="/user/logout'.$cleanpath.'" class="fright fs-m">Logout</a>'; */
			return '
				<div title="Welcome User!" class="fright fs-s" id="login_message_holder">
					<span>Welcome,</span>
					<span class="fc_starfish_green fwB pRl"> User</span>
					<a title="Edit settings" accesskey="s" id="settings_nav" href="/settings">Settings</a>
					<span class="pHxs">|</span>
					<a title="Leaving so soon!" accesskey="x" href="/user/logout'.$cleanpath.'">Logout</a>
				</div>';
		}
		else {
			return null;
		}
	}
	//===================================================================================================================================
	private function showLogInLinkIfLoggedOut()
	{
	
		if (false==authorization::areWeLoggedIn()){
			$cleanpath = $this->cleanPath(routes::getInstance()->getWholePath());
			return '<div title="Welcome User!" class="fright fs-m" id="login_message_holder">
						<span>Welcome,</span>
						<span class="fc_starfish_green fwB">User</span>
					</div>';
			/* return '<a href="/user/login'.$cleanpath.'" class="fright">Login</a>'; */
		}
		else
		{
			return null;
		}
	}
	
	private function cleanPath($path)
	{
		//to prevent long urls, or possible errors when a user presses login/logout etc repetively
		$path = str_replace("/userlogin", "", $path);
		$path = str_replace("/userlogout", "", $path);
		$path = str_replace("/register", "", $path);
		$path = str_replace("/userprofile", "", $path);
		return $path;
	}
	
}