<?php

namespace App\Models;

use App\Database;
use App\Models\User;

class Auth
{
	
	  private static function getOpts()
	  {
		$array = array();
		$array["cost"] = 12;
		  
		return $array;
	  }
  
	  public static function login($username, $password)
	  {
		  $user = User::getUserByName($username);
		  
		 
		  // Ověření existence uživatele
		  if($user == null)
		  {
			  return "Nepodařilo se ověřit údaje. Uživatel neexistuje!";
		  }
		  
		  if(User::isBlocked($user->getID()))
		  {
			  return "Tento účet byl zablokován!";
		  }
		  
		  // Ověření hesla
		  if(password_verify($password,$user->getPassword()))
		  {	  
			// Přihlášení uživatele
			$_SESSION["user"] = array();
			$_SESSION["user"]["userID"] = $user->getID();
			$_SESSION["user"]["userName"] = $user->getNickName();
			$_SESSION["user"]["email"] = $user->getEmail();
			$_SESSION["user"]["accountType"] = $user->getAccountType();
		  
			return true;
		  }
		  else
		  {
			  return "Nepodařilo se ověřit údaje. Heslo není správně!";
		  }
		  

	  }
	
	  public static function getHash($heslo)
	  {
		return password_hash($heslo, PASSWORD_BCRYPT, self::getOpts());
	  }
	  
	  public static function isLogged()
	  {
		  
		if(!isset($_SESSION["user"]["userID"]) || empty($_SESSION["user"]["userID"]))
		{
			return false;
		}
		return true;
		  
	  }
	  
	  public static function logout()
	  {
		  unset($_SESSION["user"]);
	  }
}
