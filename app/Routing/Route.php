<?php

namespace App\Routing;

use App\Routing\RouteValidator;
use App\Configuration;

/**

	Třída, která na základě validace od třídy RouteValidator
	volá či nevolá relevantní metodu z kontroleru <- definováno
	v rámci samotné cesty.

			a) Moderní URL
			Route::get("/clanky", "foo\bar\Articles@showArcticles");
			Route::get("/clanky/{title}" -> "foo\bar\Articles@getArticle");
			Route::get("/uzivatel/{username}", "foo\bar\Users@getUserByName")
				http://kiv.web.local/uzivatel/viteja -> foo\bar\Users::getUserByID("viteja");
			Route::get("/uzivatel/{id}", "foo\bar\Users@getUserById");
				http://kiv.web.local/uzivatel/1 -> foo\bar\Users::getUserByID(1);
		
			b) základní způsob URL
			Route::get("index.php?page=uzivatel&username={username}", foo\bar\Users@getUserByName);
				http://kiv.web.local/index.php?page=uzivatel&username=sognus -> foo\bar\Users::getUserByName("sognus") 
				- Část řešení v /random/parseURL2.php
			
	
	
	@author Jakub Vítek

*/
class Route
{
	// Jediná přípustná instance třídy
	private static $singleton;
	
	// Validátor Routy
	private $validator;
	
	// Nezpracované URL
	private $raw;
	
	// Příznak, zda byla Routa nalezena
	private $found;
	
	// Metoda požadavku
	private $method;
	
	
	public static function getInstance()
	{
		if(Route::$singleton == null)
		{
			Route::$singleton = new Route();
		}
		return Route::$singleton;	
	}
	
	private function __construct()
	{		
		// Příprava nutných hodnot
		$root = Configuration::get("APP_ROOT");
		$this->raw = str_replace($root, "", $_SERVER["REQUEST_URI"]);
		$this->found = false;
		
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->validator = new RouteValidator($this->raw);
		
	}
	
	public function processRoutes()
	{
		include_once(__DIR__ . "/../../routes/web.php");
		
		if(!self::getInstance()->found)
		{
			Route::error(404);
		}
		
	}
	
	public static function error($code = 500)
	{
		call_user_func_array(array("App\Controllers\ErrorController", "show"), array($code));
		
		
	}
	
	public static function post($where, $target, $types = array())
	{
		$router = self::getInstance();
		
		if($router->method != "POST")
		{
			return false;
		}
		
		return self::processRoute($where, $target, $types);
		
		
	}
	
	public static function get($where, $target, $types = array())
	{
		$router = self::getInstance();
		
		if($router->method != "GET")
		{
			return false;
		}
		
		return self::processRoute($where, $target, $types);
		
		
		
	}
	
	private static function processRoute($where, $target, $types = array())
	{
		$router = self::getInstance();
		
		// Ověří zda cíl volání je ve správném tvaru
		if(!strpos($target, "@"))
		{
			return false;
		}
		
		$target_parts = explode("@", $target);		
		$class = $target_parts[0];
		$method = $target_parts[1];
			
		// Validuje routu vůči aktuálnímu URL
		if(!$router->validator->validate($where, $types))
		{
			return false;
		}
			
		// Ověří zda daná třída existuje
		if(!class_exists($class))
		{
			return false;
		}
		
			
		// Ověří zda v dané třídě existuje požadovaná metoda
		if(!method_exists($class, $method))
		{
			return false;
		}
		
		
		// Ošetření mnohonásobného volání
		if($router->found)
		{
			return false;
		}
		
				
		// Zavolání funkce		
		call_user_func_array(array($class, $method), $router->validator->getWildcard());
		$router->found = true;
		
		return true;
		
	}

	
	
	
	
	
}