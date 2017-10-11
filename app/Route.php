<?php

namespace App;

use App\Utils\RouteValidator;
use ReflectionClass;

/**

	Třída, která na základě validace od třídy RouteValidator
	volá či nevolá relevantní metodu z kontroleru <- definováno
	v rámci samotné cesty.

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
	
	// Metoda požadavku
	private $method;
	
	
	public static function getInstance()
	{
		if(self::$singleton == null)
		{
			self::$singleton = new self();
		}
		return self::$singleton;	
	}
	

	/*
		a) Moderní URL
			Route::get("/clanky", "foo\bar\Articles@showArcticles");
			Route::get("/clanky/{title}" -> "foo\bar\Articles@getArticle");
			Route::get("/uzivatel/{username}", "foo\bar\Users@getUserByName")
				http://kiv.web.local/uzivatel/sognus -> foo\bar\Users::getUserByID("sognus");
			Route::get("/uzivatel/{id}", "foo\bar\Users@getUserById");
				http://kiv.web.local/uzivatel/1 -> foo\bar\Users::getUserByID(1);
		
		b) Jiný způsob URL
			Route::get("index.php?page=uzivatel&username={username}", foo\bar\Users@getUserByName);
				http://kiv.web.local/index.php?page=uzivatel&username=sognus -> foo\bar\Users::getUserByName("sognus") 
				- Část řešení v /random/parseURL2.php
			
			
	
	
	
	
	*/
	
	private function __construct()
	{		
		// Příprava nutných hodnot
		$this->raw = $_SERVER["REQUEST_URI"];
		$this->method = $_REQUEST["_method"] ?? $_SERVER["REQUEST_METHOD"];
		$this->validator = new RouteValidator($this->raw);
	
	
		// Zpracování routy a volání 
		$this->handle();
		$this->reflection();
	}
	
	public static function tryRoute()
	{
		Route::get("/{test}","App\Controllers\TestController@target");
		
	}
	
	public static function get($where, $target)
	{
		// Ověří zda cíl volání je ve správném tvaru
		if(!strpos($target, "@"))
		{
			return false;
		}
		
		$target_parts = explode("@", $target);		
		$class = $target_parts[0];
		$method = $target_parts[1];
		
		
		// Získání instance Route
		$router = self::getInstance();
		
		// Ověří zda metoda požadavku je get
		if($router->method != "GET")
		{
			return false;
		}
		
		// Validuje routu vůči aktuálnímu URL
		if(!$router->validator->validate($where))
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
		
		// TODO: Získat z aktuální URL hodnoty vůči routě
		// TODO: Zavolat metodu se získanými parametry
		
		
		
		
		
		
		
		
		
	}
	
	
	private function handle()
	{
		// Ukázka využití validace routy - Modern
		$test = new RouteValidator($this->raw);
		$route = "/test/test/{pes}";
		$status = $test->validate($route) ? "VALIDATED" : "REJECTED";
		//echo "Validace cesty vůči $route: ".$status;
		
		//echo "<br>";
		
		// Ukázka využití validace routy - Basic
		$test = new RouteValidator($this->raw);
		$route = "index.php?page=test&a={test}";
		$status = $test->validate($route) ? "VALIDATED" : "REJECTED";
		////echo "Validace cesty vůči $route: ".$status;
		
		//echo "<br>";	
	
		// Ukázka využití validace routy - Modern
		$test = new RouteValidator($this->raw);
		$route = "/test/{test}";
		$status = $test->validate($route) ? "VALIDATED" : "REJECTED";
		//echo "Validace cesty vůči $route: ".$status;
		
		
		
		
	}
	

	
	
	
	
	
}