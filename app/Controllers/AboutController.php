<?php

namespace App\Controllers;

use App\Views\Twig;

class AboutController
{
	
	public static function show()
	{
		$data = array();
		$data["session"] = $_SESSION;
		Twig::render("about.tpl", $data);
		
	}
	
	
	
	
	
	
}