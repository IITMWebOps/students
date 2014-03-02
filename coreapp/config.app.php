<?php

class AppConfig{
	const LDAP = true;
	const ENV_PRODUCTION = true;
  const DATABASE = 'MySQLDB_students';
  public static $PRIMARY_ROUTES = array(
    '/^$/' => 'index/index.php'
  );
  public static $SECONDARY_ROUTES = array(
    '/^[a-zA-Z]{2}[0-9]{2}[a-zA-Z]{1}[0-9]{3}$/' => 'profile/index.php',
    '/^pages\//' => 'pages/page.php' 
  );
}

?>
