<?php

namespace App\Controllers;

use App\Views\View;

class HelloWorldController
{
	
	
	public static function show()
	{
			// "{$test}"
			
			View::make("hello.tpl", array("user"=>"Sognus"));
		
	}
	
	
	
	
}