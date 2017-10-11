<?php

namespace App;

use App\Utils\RouteValidator;

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
		
		$this->raw = $_SERVER["REQUEST_URI"];
		$this->method = $_REQUEST["_method"] ?? $_SERVER["REQUEST_METHOD"];
		$this->handle();
	}
	
	private function handle()
	{
		// Ukázka využití validace routy - Modern
		$test = new RouteValidator($this->raw);
		$route = "/test/test/{pes}";
		$status = $test->validate($route) ? "VALIDATED" : "REJECTED";
		echo "Validace cesty vůči $route: ".$status;
		
		echo "<br>";
		
		// Ukázka využití validace routy - Basic
		$test = new RouteValidator($this->raw);
		$route = "index.php?page=test&a={test}";
		$status = $test->validate($route) ? "VALIDATED" : "REJECTED";
		echo "Validace cesty vůči $route: ".$status;
		
		
		
		
	}
	

	
	
	
	
	
}