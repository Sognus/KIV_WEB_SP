<?php

namespace App\Controllers;

use App\Views\Twig;

use App\Models\Auth;
use App\Models\User;

class LoginController
{
	
	public static function show()
	{
		$logged = Auth::isLogged();
		
		// Pokud uživatel je již přihlášen, přesměrovat ho
		if($logged)
		{
			header("Location: index.php?page=about");
			die();
		}
		
		$data = array();
		$data["session"] = $_SESSION;
		Twig::render("login.tpl", $data);
	}
	
	public static function post()
	{
		$data = array();
		$data["session"] = $_SESSION;
	
		$logged = Auth::isLogged();
	
		// Pokud uživatel je již přihlášen, přesměrovat ho
		if($logged)
		{
			header("Location: index.php?page=about");
			die();
		}
	
		
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
				
				if($auth === true)
				{
					$data["loginSuccess"] = true;	
					$logged = true;
				}
				else
				{
					$data["loginErrorMessage"] = $auth;
					$logged = false;					
				}
				
			}
			
		}
		
		Twig::render("login.tpl", $data);
		
		// Přesměrování uživatele
		if($logged === true)
		{
			header("Location: index.php?page=about");
			die();
		}
		
		
	}

	
	
}