<?php

//get server name
$svn = $_SERVER['SERVER_NAME'];
//get server address
$sip =  $_SERVER['SERVER_ADDR'];
	
//okay, maybe we need this for multilingual sites.
$GLOBALS['domainAndCountryCodes'] = array(
	array('domain' => 'starfish.es', 'countrycode' => 'es'),
	array('domain' => 'starfish.co.uk', 'countrycode' => 'en'),
	array('domain' => 'starfish.ph', 'countrycode' => 'ph')
);


//load the different settings for each environment

//localhost
if (strpos($sip,"127.0.0.1") !== FALSE) 
	require_once "Parameters/developers_environment.php";

//test site
//strpos returns the position of the string 
//that's why we need !== in case if returns 0 (first index)
elseif (strpos($svn, "starfi.sh") !== FALSE) 
	require_once "Parameters/staging_environment.php";

//otherwise it's live
else 
	require_once "Parameters/live_environment.php";

//-------------------------------------------------------------------------------------------------
//DEFINE THE LANGUAGES SETTING 
//Options are: SINGLE_DOMAIN_MULTILINGUAL, MULTIPLE_DOMAIN_MULTILINGUAL, SINGLE_LANGUAGE
define('MULTILINGUAL_SETTING','MULTIPLE_DOMAIN_MULTILINGUAL');	

//-------------------------------------------------------------------------------------------------
//DEFINE THE GENERAL FRAMEWORK FOLDERS - hardly ever changes 
require_once "Parameters/framework_directory_structure.php";

//-------------------------------------------------------------------------------------------------
// RUN THE WEBSITE
require_once FILE_ACCESS_CORE_CODE.'/Framework/FrontController/frontController.php';

error_reporting(E_ALL);
ini_set('display_errors','On');

try
{
    $frontController = frontController::getInstance();
    $frontController->init();
    $frontController->dispatch();
} 
catch (Exception $exp) 
{
	//we might want to change how we handle exceptions
	
    header("Content-Type: text/html; charset=utf-8"); 
    echo 'Oops.';
    echo '<h2>Unexpected Exception: ' . $exp->getMessage() . '</h2><br /><pre>';
    echo $exp->getTraceAsString();   
}
?>