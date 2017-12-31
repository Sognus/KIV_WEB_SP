<?php

namespace App\Controllers;

use App\Views\Twig;

use App\Models\Auth;
use App\Models\User;

class LoginController
{
	
	public static function show()
	{
		Twig::render("login.tpl");
	}
	
	public static function post()
	{
		$data = array();
		
		// Základní ošetření, vytažení dat z _POST
		foreach($_POST as $key => $value)
		{
			${$key} = htmlspecialchars(trim($value));
		}
		
		if(isset($_POST["login"]))
		{
			$chyba = false;
			$user = User::getUserByName($name);		
		
			// Bylo zadáno jméno
			if(strlen($name) < 1)
			{
				// Data nebyla vyplněna
				$data["loginErrorUsername"] = "Jméno nebylo zadáno!";
				$chyba = true;
				
			}
			else
			{
				
				// Existuje uživatel?
				if($user == null)
				{
					$data["loginErrorUsername"] = "Uživatel s daným jménem neexistuje!";
					$chyba = true;
				}
				else
				{
					$data["loginCacheUsername"] = $login;
				}
				
			}
			
			// Bylo zadáno heslo?
			if(strlen($password) < 1)
			{
				$data["loginErrorPassword"] = "Heslo nebylo zadáno!";
				$chyba = true;
			}
			
			// Pokus o přihlášení
			if($chyba == false)
			{
				$auth = Auth::login($name, $password);
							
				if($auth != true)
				{
					$data["loginErrorMessage"] = "Nepodařilo se ověřit údaje! ".$auth;
				}
				else
				{
					$data["loginSuccess"] = true;			
				}
				
			}
			
		}
		
		Twig::render("login.tpl", $data);
		
		
	}

	
	
}