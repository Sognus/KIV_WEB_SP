<?php

namespace App\Controllers;

use App\Views\Twig;

class ErrorController
{
	
	public static function show($code)
	{
		switch($code)
		{
			case 404:
				Twig::render("error.tpl", array("code"=>404, "message"=>"Stránka nenalezena"));
				die();
				break;
			case "D001":
				Twig::render("error.tpl", array("code"=>"D001", "message"=>"Nastala chyba databáze, která znemožnila registraci uživatele"));
				die();
			default:
				Twig::render("error.tpl", array("code"=>500, "message"=>"Interní chyba aplikace"));
				die();
		}
		
		
		
	}

	
	
}