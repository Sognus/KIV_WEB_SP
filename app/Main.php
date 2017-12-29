<?php

namespace App;

use App\Database;
use App\Routing\Route;

Class Main
{
	private $router;
	
	public static function start()
	{
		$app = new self();
		$app->run();
	} 
	
	private function __construct()
	{
	}
	
	public function run()
	{
		// Počáteční nastavení aplikace
		$this->init();
		
		// Na základě routy zavolá kontroler který provede vše potřebné
		$this->router->processRoutes();
		
	}
	
	/** Nastaví všechny počáteční hodnoty a provede inicializační procedury */
	private function init()
	{
		Database::ConnectINI();
		$this->router = Route::getInstance();
	}
	
	
	
	
	
}


?>