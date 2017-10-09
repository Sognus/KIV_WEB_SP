<?php

namespace App;

Class Configuration
{
	private static $configuration;
	
	private static function loadConfiguration()
	{
			// Načte konfigurační hodnoty ze souboru a změní jejich klíče na velká písmena
			self::$configuration = parse_ini_file(__DIR__ . "/../configuration.ini");
			self::$configuration = array_change_key_case(self::$configuration, CASE_UPPER);		
	}
	
	private static function checkConfiguration()
	{
		if(empty(self::$configuration))
		{
			return false;
		}
		return true;
		
		
	}
	
	public static function get($key)
	{
		if(!self::checkConfiguration())
		{
			self::loadConfiguration();
		}
		
		// Změna vyhledávacího klíče na velká písmena
		$key = mb_strtoupper($key, 'UTF-8'); 
		
		if(array_key_exists($key, self::$configuration));
			return self::$configuration[$key];
		
		// Zadaný klíč nebyl nalezen
		return null;
		
	}
	
	
	
	
	
	
	
}




?>