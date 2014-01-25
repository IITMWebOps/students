<?php
session_start();

define('DS', DIRECTORY_SEPARATOR, false);
define('ROOT', dirname(dirname(__FILE__)), false );
define('APP_ROOT', ROOT . DS . "apps", false );
define('PUBLIC_ROOT', ROOT . DS . "public", false );

define('APP_NAME', 'Students Portal', false);
define('APP_HOST','http://students.iitm.ac.in',false);
define('APP_SUBPATH','spapp',false);
define('APP_URL', APP_HOST . '/'  . APP_SUBPATH, false);

define('ASSETS_ROOT', APP_URL . '/'  . "assets", false );
define('IMG_ROOT', ASSETS_ROOT . '/' . "images", false );
define('CSS_ROOT', ASSETS_ROOT . '/' . "css", false );
define('JS_ROOT', ASSETS_ROOT . '/' . "js", false );
define('APPJS_ROOT', ASSETS_ROOT . '/' . "applicationjs", false );


	require_once (ROOT . DS . 'coreapp' . DS . 'appconfig.php');
	require_once (ROOT . DS . 'coreapp' . DS . 'route.php');
	require_once (ROOT . DS . 'coreapp' . DS . 'dbconfig.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'httpresponse.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'redirectTo.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'currentuser.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'pageTitle.php');



  
class Application{

	public $dbcon;
	public $route;

	function __construct(){

		$Database_Class = AppConfig::DATABASE;
		$this->dbcon = new $Database_Class();
	}

	function setReporting() {
		if (AppConfig::ENV_PRODUCTION == false) {
			error_reporting(E_ALL);
			ini_set('display_errors','On');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', ROOT.DS.'logs'.DS.'error.log');
		}
	}
 
}

$ap = new Application();
$ap->setReporting();
$ap->route = new GetRoute(AppConfig::$PRIMARY_ROUTES,AppConfig::$SECONDARY_ROUTES);

$current_user = new CurrentUser();

error_log($ap->route->pageURI,0);
$targetPath = APP_ROOT.DS.$ap->route->GetTarget($ap->route->pageURI);
error_log($targetPath,0);
$targetPath = is_file($targetPath) ? $targetPath : PUBLIC_ROOT . DS . '404.html';
error_log($targetPath,0);

include $targetPath;
?>
