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
	
	// Salt pro PHP starší než 7.0.0
	if((version_compare(phpversion(), '7.0.0', '<')) )
	{
		$array["salt"] = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
	}
	  
	return $array;
  }
  
  public static function login($username, $password)
  {
	  $user = User::getUserByName($username);
	  
	  // Ověření existence uživatele
	  if($user == null)
	  {
		  return "Uživatel neexistuje!";
	  }
	  
	  // Ověření hesla
	  if(!password_verify($password, $user->getPassword()))
	  {
		  return "Heslo není správné";
	  }		  
	  
	  // Přihlášení uživatele
	  $_SESSION["userID"] = $user->getID();
	  
	  return true;
  }
	
  public static function getHash($heslo)
  {
    return password_hash($heslo, PASSWORD_BCRYPT, self::getOpts());
  }
}
