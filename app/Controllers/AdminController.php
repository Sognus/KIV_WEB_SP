<?php

namespace App\Controllers;

use App\Routing\Route;
use App\Views\Twig;

use App\Models\Auth;
use App\Models\User;

class AdminController
{
	
	public static function show()
	{
		$args = func_get_args();
		$template = "admin.tpl";
		
		// Standardní hlavička
		$data = array();
		$data["session"] = $_SESSION;
			
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isAdministrator($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		// Rozhodnutí template, která se má načíst
		$part = isset($args[0]) ? $args[0] : "none";
		
		switch($part)
		{
			case "none":
				$template = "admin.tpl";
				break;
			case "users":
				$template = "admin-users.tpl";
				$data["users"] = User::getUsersList();
				break;
			default:
				$template = "admin.tpl";		
		}
		
		// Vykreslení stránky
		Twig::render($template, $data);
		
		
	}
	
	public static function post()
	{
		
		if(isset($_POST))
		{
			
			// Změnit uživatele na administrátora
			if(isset($_POST["admin"]))
			{
				User::changeAccountType($_POST["admin"], 2);				
			}
			
			// Změnit uživatele na autora
			if(isset($_POST["autor"]))
			{
				$user = User::getUserByID($_POST["autor"]);
				
				if($user->getAccountType() !== 2)
				{
					User::changeAccountType($_POST["autor"], 0);
				}					
			}
			
			// Změnit uživatele na autora
			if(isset($_POST["recenzent"]))
			{
				$user = User::getUserByID($_POST["recenzent"]);
				
				if($user->getAccountType() !== 2)
				{
					User::changeAccountType($_POST["recenzent"], 1);
				}	
			}
			
		}
		
		self::show("users");
		
		
	}
	
}