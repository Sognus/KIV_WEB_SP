<?php

namespace App;

use PDO;
use PDOException;
use Exception;

Class Database
{
	private static $connection;
	
	public static function connect($host, $user, $password, $database, $port = 3306)
	{
		// Připravení DSN
		$dsn = sprintf("mysql:dbname=%s;host=%s;port=%d;charset=utf8",$database, $host, $port);
		
		// Pokus o připojení
		try
		{
			self::$connection = new PDO($dsn, $user, $password);
			self::setAttributes();
			
		}
		catch (PDOException $e)
        {
			die("Nelze se připojit do databáze!");
			
        }
	}
	
	private static function setAttributes()
	{
		self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		self::$connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
		self::$connection->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
	}
	
	
	
	
	
}


?>