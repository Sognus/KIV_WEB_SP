<?php

namespace App\Controllers;

use App\Views\Twig;
use App\Configuration;
use App\Routing\Route;

use App\Models\User;
use App\Models\Auth;

class RegisterController
{
	// Zpracování stránky register při volání metodou GET
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
		Twig::render("register.tpl", $data);
	}
	
	// Zpracování stránky register při volání metodou POST
	public static function post()
	{
		$data = array();
		$data["session"] = $_SESSION;
		$data = $_SESSION;
		
		// Základní ošetření, vytažení dat z _POST
		foreach($_POST as $key => $value)
		{
			${$key} = htmlspecialchars(trim($value));
		}
		
		
		if(isset($_POST["register"]))
		{
			// Chyba značí, zda některý ze vstupů nevyhovuje požadavkům 
			$chyba = false;
			
			$user = User::getUserByName($name);
			
			// Dané jméno není zabráno - je možné jej registrovat
			if(strlen($name) < 1)
			{
				$data["registerErrorUsername"] = "Jméno nebylo zadáno!";
				$chyba = true;
			}
			else
			{
				if($user != null)
				{
					// Jméno je zabráno
					$data["registerErrorUsername"] = "Uživatel s tímto jménem již existuje!";
					$chyba = true;
					
			
				}
				else
				{
					// Vložení dat do cache, aby se usnadnil výpis uživateli
					$data["registerCacheUsername"] = $name;
			}
			}
			
			// Nastavení vlastností filter_var
			$options = array
			(
				"default" => false,
			);
				
			// Ověření, zda vstup je validní e-mail
			if(strlen($email) < 1)
			{
				$data["registerErrorEmail"] = "E-mail nebyl zadán!";
				$chyba = true;
			}
			else
			{
				if(!filter_var($email, FILTER_VALIDATE_EMAIL, $options))
				{
					// Vstup není validní e-mail
					$data["registerErrorEmail"] = "Vstup není e-mail!";
					$chyba = true;
				}
				else
				{
					$data["registerCacheEmail"] = $email;
					
						
				}
			}
			
			// Ověření zda heslo je dostanečně dlouhé
			$requiredLength = Configuration::get("USER_PASSWORD_MIN");
			
			if(strlen($password) < 1)
			{
				$data["registerErrorPassword"] = "Heslo nebylo zadáno!";
				$chyba = true;
				
			}
			else
			{
				if(strlen($password) < $requiredLength)
				{
					$data["registerErrorPassword"] = "Heslo není dostatečně dlouhé!";
					$chyba = true;
				}
				else
				{
					// Heslo se do cache neukládá - teoreticky by mohlo - nechávám zde block else pro jistotu
					
				}
			}
			
			// Ověření zda heslo i potvrzení hesla jsou stejné
			if(strlen($passwordConfirm) < 1)
			{
				$data["registerErrorConfirm"] = "Potvrzení hesla nebylo zadáno!";
				$chyba = true;
			}
			else
			{
				if($passwordConfirm != $password)
				{
					$data["registerErrorConfirm"] = "Hesla nejsou stejná!";
					$chyba = true;
					
				}
				else
				{
					// Heslo se do cache neukládá - teoreticky by mohlo - nechávám zde block else pro jistotu
				}
			}
			
			// Pokud vše prošlo správně registruj uživatele
			if($chyba == false)
			{
				if(User::registerNewUser($name, $password, $email) == true)
				{
					// Zrušení hodnot, protože nejsou dále potřeba
					unset($data["registerCacheEmail"]);
					unset($data["registerCacheUsername"]);
			
					// Nastavení příznaku úspěšné registrace
					$data["registerSuccess"] = true;
				}
				else
				{
					Route::error("D001");
					return;
				}
			}
			
			
		
		}
			
		Twig::render("register.tpl", $data);
			
			
	}

	
	
}