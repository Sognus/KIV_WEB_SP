<?php

namespace App\Controllers;

use App\Models\Auth;

class LogoutController
{
	
	public static function logout()
	{
		// Logout uživatele
		Auth::logout();
		
		// Přesměrování uživatele
		header("Location: index.php?page=about");
		die();
		
	}
	
	
	
}