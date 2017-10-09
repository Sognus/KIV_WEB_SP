<?php

namespace App;

class Route
{
	// Jediná přípustná instance třídy
	private static $singleton;
	
	// Nezpracované URL
	private $raw;
	
	// Metoda požadavku
	private $method;
	
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
			
			
	
	
	
	
	*/
	
	private function __construct()
	{
		
		$this->$raw = urldecode($_SERVER["REQUEST_URI"]);
		$this->$method = $_REQUEST["_method"] ?? $_SERVER["REQUEST_METHOD"];
		$this->parse();
	}
	
	// Na základě tvaru požadované adresy zpracuje požadovanou URL
	private function parse()
	{
		
		
		
	}
	
	
	
	
	
}