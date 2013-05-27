<?
//====================================================================================================
//PERMANENT FIXTURES OF THE FRAMEWORK THAT CANNOT BE TOUCHED without having to change the framework around
//they should not be modified 

//The document root directory under which the current script is executing, as defined in the server's configuration file. 
define('STAR_SITE_ROOT',(($_SERVER['DOCUMENT_ROOT'])));
//THIS ISNT WORKING
define('DEBUG_LOG_FILE', STAR_SITE_ROOT.'/Data/'.DOMAIN.'/Backend/temp/debug.txt');

//USED IN CMS BUT NEEDS TO BE RETHOUGHT
define('BACKUPS_DIRECTORY','Data/backups');
define ('TIMEZONE','Asia/Manila');

//PHOTO LIBRARY DIRECTORY
define('PHOTO_LIBRARY_DIRECTORY','Data/Images');

//===================================================================================================
//Thse are all for HTTP access OR FILE access of the Current Domain  since the it uses RELATIVE PATH

define('STAR_CODE_MAINLAYOUT','/Project/'.DOMAIN.'/Code/Main_Layout');
define('STAR_CODE_PAGES','/Project/'.DOMAIN.'/Code/Pages');
define('STAR_CODE_APPLICATIONS','/Project/'.DOMAIN.'/Code/Applications');

define('STAR_DESIGN_MAINLAYOUT','/Project/'.DOMAIN.'/Design/Main_Layout');
define('STAR_DESIGN_PAGES','/Project/'.DOMAIN.'/Design/Pages');
define('STAR_DESIGN_PANELS','/Project/'.DOMAIN.'/Design/Panels');
define('STAR_DESIGN_PLUGINS','/Project/'.DOMAIN.'/Design/Plugins');

//===================================================================================================
//CORE ACCESS
//has to explicitly define the whole path. 
define('HTTP_ACCESS_CORE_CODE_MODULES',HTTP_ACCESS_CORE.'/Core/Code/Modules');
define('HTTP_ACCESS_CORE_CODE_OBJECTS',HTTP_ACCESS_CORE.'/Core/Code/Modules');

define('HTTP_ACCESS_CORE_DESIGN_PLUGINS',HTTP_ACCESS_CORE.'/Core/Design/Plugins');
//===================================================================================================
// FILE_ACCESS_CORE is defined in development, staging and live parameters
define('FILE_ACCESS_CORE_CODE',FILE_ACCESS_CORE.'/Core/Code');
define('FILE_ACCESS_CORE_DESIGN',FILE_ACCESS_CORE.'/Core/Design');
define('FILE_ACCESS_CORE_DATA',FILE_ACCESS_CORE.'/Data');


?>