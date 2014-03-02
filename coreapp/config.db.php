<?php

//namespace MySQLDB

final class MySQLDB_students{

	private static $host = 'localhost';
	private static $user = 'students';
	private static $password = '13InstiWO';
	private static $database = 'students';

	function __construct(){
		mysql_connect(self::$host, self::$user, self::$password, self::$database) or die(" ERROR MAKING CONNECTION   ");
	}
}



?>
