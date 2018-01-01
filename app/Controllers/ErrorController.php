<?php

namespace App\Controllers;

use App\Views\Twig;

class ErrorController
{
	
	public static function show($code)
	{
		$data = array();
		$template = "error.tpl";
		
		$data = array();
		$data["session"] = $_SESSION;
		
		switch($code)
		{
			case 404:
				$data["code"] = 404;
				$data["message"] = "Stránka nenalezena";
				break;
			case "D001":
				$data["code"] = "D001";
				$data["message"] = "Nastala chyba databáze, která znemožnila registraci uživatele";
				break;
			default:
				$data["code"] = 500;
				$data["message"] = "Interní chyba aplikace";
		}
		
		Twig::render($template, $data);
		die();
		
		
		
	}

	
	
}