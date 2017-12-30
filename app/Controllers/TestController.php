<?php

namespace App\Controllers;

use App\Views\Twig;

class TestController
{
	
	public static function target()
	{	
		Twig::render("test.tpl");
		
	}
	
	
	
	
	
	
}