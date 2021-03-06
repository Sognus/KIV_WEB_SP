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
		$sql = "SELECT * FROM viteja_web_users WHERE LOWER(user) = LOWER( :id ) AND deleted != '1' LIMIT 1";
		
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
	
	// Vrací uživatele
	public static function getUsersList()
	{
		$sql = "SELECT * FROM viteja_web_users WHERE deleted != '1'";
		
		$result = Database::query($sql);
		$rows = Database::numRows($result);
		
		if($rows < 1)
		{
			return array();
		}
		
		$assoc = Database::assocAll($result);
		
		for($i = 0; $i < count($assoc); $i++)
		{
			$assoc[$i]["banned"] = User::isBlocked($assoc[$i]["user"]);
		}
		
		
		return $assoc;	
	}
	
	
	// Vrací jednu instanci třídy user
	public static function getUserByName($name, $safe = false)
	{
		$sql = "SELECT * FROM viteja_web_users WHERE name = :name AND deleted != '1' LIMIT 1";
		
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
	
	public static function isReviewer($id)
	{
		$user = self::getUserByID($id);
		
		if($user == null)
		{
			return false;
		}
		
		return ($user->getAccountType() >= 1);
				
	}
	
	public static function isAdministrator($id)
	{
		$user = self::getUserByID($id);
		
		if($user == null)
		{
			return false;
		}
		
		return ($user->getAccountType() === 2);
		
	}
	
	public static function isBlocked($id)
	{
		$sql = "SELECT * FROM viteja_web_users WHERE user = :id AND blocked = '1' LIMIT 1";
		
		$where = array
		(
			":id" => $id,
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		
		return ($rows > 0);
		
		
	}
	
	public static function changeAccountType($userID, $type)
	{
		if(!in_array($type, array(0, 1, 2)))
		{
			return false;
		}
		
		$user = self::getUserByID($userID);
		
		if($user == null)
		{
			return false;
		}
		
		$sql = "UPDATE `viteja_web_users` SET `account` = :type WHERE `viteja_web_users`.`user` = :id ;";
		
		$data = array
		(
			":id" => $userID,
			":type" => $type,
		);
		
		return (Database::query($sql, $data) !== false);
		
	}
	
	public static function banUserByID($id)
	{	
		$sql = "UPDATE `viteja_web_users` SET `blocked` = '1' WHERE `viteja_web_users`.`user` = :id ;";
		
		$where = array
		(
			":id" => $id,
		);
		
		Database::query($sql, $where);
		
	}
	
	public static function unbanUserByID($id)
	{	
		$sql = "UPDATE `viteja_web_users` SET `blocked` = '0' WHERE `viteja_web_users`.`user` = :id ;";
		
		$where = array
		(
			":id" => $id,
		);
		
		Database::query($sql, $where);
		
	}
	
	public static function deleteUserByID($id)
	{
		
		$sql = "UPDATE `viteja_web_users` SET `deleted` = '1' WHERE `viteja_web_users`.`user` = :id ;";
		
		$where = array
		(
			":id" => $id,
		);
		
		Database::query($sql, $where);
		
	}
	
	
	
	
	
	
}