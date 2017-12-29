<?php

namespace App\Controllers;

use App\Views\Twig;

class TestController
{
	
	public static function target()
	{
		print_r(func_get_args());
		echo "REFLECTION BASED CALL";
		
		Twig::render("test.tpl");
		
	}
	
	
	
	
	
	
}