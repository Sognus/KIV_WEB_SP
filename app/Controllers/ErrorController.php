<?php

namespace App\Controllers;

class ErrorController
{
	
	public static function show($code)
	{
		switch($code)
		{
			case 404:
				die("Chyba 404 - Stránka nenalezena");
				break;	
			default:
				die("Chyba 500 - Interní chyba aplikace");
		}
		
		
		
	}

	
	
}