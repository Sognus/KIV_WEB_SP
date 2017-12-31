<?php

namespace App\Controllers;

use App\Views\Twig;

class AboutController
{
	
	public static function show()
	{	
		Twig::render("about.tpl");
		
	}
	
	
	
	
	
	
}