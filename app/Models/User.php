<?php

namespace App\Models;

use App\Database;
use App\Models\Auth;

class User
{
	// Identifikační číslo uživatele
	private $id;
	
	// Přezdívka uživatele
	private $name;
	
	// Heslo uživatele - hash
	private $password;
	
	// Email uživatele
	private $email;
	
	// Typ účtu uživatele
	private $accountType;
	
	
	private function __construct($id, $name, $password, $email, $accountType)
	{
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
		$this->email = $email;
		$this->accountType = $accountType;
		
	}
	
	public function getID()
	{
		return $this->id;
	}
	
	public function getNickname()
	{
		return $this->name;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getAccountType()
	{
		return $this->accountType;
	}
	
	// Vrací jednu instanci třídy User 
	public static function getUserByID($id, $safe = false)
	{
		$sql = "SELECT * FROM viteja_web_users WHERE LOWER(user) = LOWER( :id ) LIMIT 1";
		
		$where = array
		(
			":id" => $id,
		);
		
		$result = Database::query($sql, $where);
		$records = Database::numRows($result);
		$assoc = Database::assoc($result);
		
		if($records < 1)
		{
			return null;
		}
		
		// Bezpečný get bez hesla
		$assoc["password"] = $safe == true ? "" : $assoc["password"];
		
		return new self($assoc["user"], $assoc["name"], $assoc["password"], $assoc["email"], $assoc["account"]);
		
	}
	
	
	// Vrací jednu instanci třídy user
	public static function getUserByName($name, $safe = false)
	{
		$sql = "SELECT * FROM viteja_web_users WHERE name = :name LIMIT 1";
		
		$where = array
		(
			":name" => $name,
		);
		
		$result = Database::query($sql, $where);
		$records = Database::numRows($result);
		$assoc = Database::assoc($result);
		
		if($records < 1)
		{
			return null;
		}
		
		// Bezpečný get bez hesla
		$assoc["password"] = $safe == true ? "" : $assoc["password"];
		
		return new self($assoc["user"], $assoc["name"], $assoc["password"], $assoc["email"], $assoc["account"]);
	}
	
	// Vytvoří nový záznam uživatele v databázi
	public static function registerNewUser($name, $password, $email)
	{
		if(self::getUserByName($name) != null)
		{
			return;
		}
		
		
		$sql = "INSERT INTO `viteja_web_users` (`user`, `name`, `password`, `email`, `account`) VALUES (NULL, :name, :password, :email, '0');";
		
		$data = array
		(
			":name" => $name,
			":password" => Auth::getHash($password),
			":email" => $email,
		);
		
		$status = Database::query($sql, $data) == false ? false : true;
		
		// Uživatele se podařilo registrovat
		return $status;
		
		
	}
	
	
	
	
	
	
}