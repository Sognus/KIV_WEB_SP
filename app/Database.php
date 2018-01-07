<?php

namespace App;

use App\Configuration;

use PDO;
use PDOException;
use Exception;

Class Database
{
	private static $connection;
	

	/** Připojí se do databáze za pomocí hodnot z konfigurace */
	public static function connectINI()
	{
		$host = Configuration::get("DB_HOST");
		$user = Configuration::get("DB_USERNAME");
		$database = Configuration::get("DB_DATABASE"); 
		$password = Configuration::get("DB_PASSWORD");
		Database::connect($host, $user, $password, $database, 3306);
	}
	
	/** Připojí se do databáze za pomocí ručně zadaných hodnot */
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
		
		self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		self::$connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
		self::$connection->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
	}
	
	public static function query($sql, $where = NULL)
	{
		$sth = self::$connection->prepare($sql);
		
		try
		{
			$sth->execute($where);
			
		} 
		catch (PDOException $ex)
		{
			print_r($ex->getMessage());
		}		
		
		return $sth;
		
	}
	
	public static function assoc($result)
	{
		$res = $result->fetch(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function assocAll($result)
	{
		$res = $result->fetchAll(PDO::FETCH_ASSOC);
		return $res;
		
	}
	
	public static function numRows($result)
	{
		$res = $result->rowCount();
		return $res;
	}
	
	public static function lastInsertID()
	{
		return self::$connection->lastInsertId();
	}
	
	
	
	
	
	
	
	
}


?>