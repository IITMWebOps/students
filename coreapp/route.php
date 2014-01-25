<?php

class GetRoute{

	static $primary_routes;
	static $secondary_routes;
	public $pageURL;
	public $pageURI;
	
	public function __construct ( $primary_routes,$secondary_routes ){
		self::$primary_routes= (is_array($primary_routes) ? $primary_routes : array());
		self::$secondary_routes = (is_array($secondary_routes) ? $secondary_routes : array());
		$this->pageURL = ((@$_SERVER["HTTPS"] == "on") ? "https://" : "http://").$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$this->pageURI = str_replace(APP_URL,"",$this->pageURL);
	}

  public function GetTarget  ( $path ){
    $primary = $this->GetTarget_route($path,self::$primary_routes);
    if ( $primary ) return $primary;
    else{
      $file = $this->MatchApp( $path );
      return ( $file ? $file : $this->GetTarget_route($path,self::$secondary_routes) );
    }
    return null;
  }
	public function GetTarget_route  ( $path, $route ){
		$path = $path[0] == '/' ? substr($path, 1) : $path;
		$path = substr($path, -1) == '/' ? substr($path, 0, -1) : $path;
		foreach( $route as $reg => $app ){	
			if ( preg_match($reg,$path) ) return $app;
		}
		return null;	
	}
	public function MatchApp( $path ){ error_log($path);
		$path = $path[0] == '/' ? substr($path, 1) : $path;
		$path = substr($path, -1) == '/' ? substr($path, 0, -1) : $path;
    if ( substr_count($path, '?') > 3) error_log("Two question marks in URL #29 coreapp/route.php");
		list( $sub_path ) = explode("?",$path);
		return ( is_file( APP_ROOT . DS . $sub_path.'.php' ) ) ? $sub_path.'.php' : (is_dir( APP_ROOT . DS . $sub_path ) ? $sub_path. DS ."index.php" : null );
	
	}


}

?>
