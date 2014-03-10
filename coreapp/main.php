<?php
session_start();

define('DS', DIRECTORY_SEPARATOR, false);
define('ROOT', dirname(dirname(__FILE__)), false );
define('APP_ROOT', ROOT . DS . "apps", false );
define('PUBLIC_ROOT', ROOT . DS . "public", false );
define('ASSETS_DIR_ROOT', ROOT . DS . "assets", false );
define('FILE_DIR_ROOT', ASSETS_DIR_ROOT . DS . "files", false );


  require_once (ROOT . DS . 'coreapp' . DS . 'config.app.php');
	require_once (ROOT . DS . 'coreapp' . DS . 'config.db.php');

  require_once (ROOT . DS . 'coreapp' . DS . 'class.user.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'class.current_user.php');
	require_once (ROOT . DS . 'coreapp' . DS . 'class.get_route.php');

  require_once (ROOT . DS . 'coreapp' . DS . 'function.http_response_code.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'function.redirect_to.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'function.page_title.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'function.mysql_fetch_all.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'function.render_alert.php');
  require_once (ROOT . DS . 'coreapp' . DS . 'function.upload_file.php');

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

trigger_error(__FILE__ );
$targetPath = APP_ROOT.DS.$ap->route->GetTarget($ap->route->pageURI);
error_log($targetPath,0);
$targetPath = is_file($targetPath) ? $targetPath : PUBLIC_ROOT . DS . '404.html';
error_log($targetPath,0);
include $targetPath;

die();  
?>
