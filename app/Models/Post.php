<?php

namespace App\Models;

use DateTime;

use App\Database;
use App\Configuration;

use App\Models\User;


class Post
{
	
	// ID příspěvku
	private $id;
	
	// ID autora příspěvku
	private $author;
	
	// Název příspěvku
	private $title;
	
	// Text příspěvku
	private $text;
	
	// Čas schválení
	private $published;
	
	
	private function __construct($id, $author, $title, $text, $published)
	{
			$this->id = $id;
			$this->author = $author;
			$this->title = $title;
			$this->text = $text;
			$this->published = $published;		
	}
	
	public function getID()
	{
		return $this->id;
	}
	
	public function getAuthorID()
	{
		return $this->id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getContent()
	{
		return $this->text;
	}
	
	public function getPublished()
	{
		return $this->published;
	}
	
	// Vrací App\Models\User nebo null
	public function getAuthor()
	{
		return User::getUserByID($this->author);
	}
	
	public static function getPostByID($id)
	{
		$sql = "SELECT * FROM `viteja_web_posts` WHERE post = :id LIMIT 1";
		
		$where = array
		(
			":id" => $id, 
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		$assoc = Database::assoc($result);
		
		if($rows < 1)
		{
			return null;
		}
		
		return new self($assoc["post"], $assoc["author"], $assoc["title"], $assoc["text"], $assoc["published"]);
		
		
	}
	
	public static function getAllPosts()
	{	
		// Dotaz
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL ORDER BY published DESC, post DESC";
		
		// Získání dat
		$posts = Database::assocAll(Database::query($sql));
		
		// Zpracování a formátování dat
		for($i = 0; $i < count($posts); $i++)
		{
			// Informace o autorovi
			$authorID = $posts[$i]["author"];
			$posts[$i]["user"] = User::getUserByID($authorID, true);
			
			// Formátování data
			$date = new DateTime($posts[$i]["published"]);
			$posts[$i]["published"] =  $date->format('d.m.Y - H:i:s');
		}
		
		// Vrácení dat
		return $posts;
		
	}
	
	public static function getPagePosts($page)
	{
		// Dotaz
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL ORDER BY published DESC, post DESC LIMIT :page , :limit ";
		
		$limit = Configuration::get("POST_PAGE_COUNT");
		
		$where = array
		(
			":page" => ($page * $limit) - $limit,
			":limit" => $limit,
		);
		
		// Získání dat
		$posts = Database::assocAll(Database::query($sql, $where));
		
		// Zpracování a formátování dat
		for($i = 0; $i < count($posts); $i++)
		{
			// Informace o autorovi
			$authorID = $posts[$i]["author"];
			$posts[$i]["user"] = User::getUserByID($authorID, true);
			
			// Formátování data
			$date = new DateTime($posts[$i]["published"]);
			$posts[$i]["published"] =  $date->format('d.m.Y - H:i:s');
		}
		
		// Vrácení dat
		return $posts;		
		
		
	}
	
	public static function getPageCount()
	{
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL";
		
		$result = Database::query($sql);
		$rows = Database::numRows($result);
		
		$onePage = Configuration::get("POST_PAGE_COUNT");
		$pages = ceil($rows / $onePage);
		
		// Musí být minimálně 1 stránka - ikdyž prázdná
		if($pages < 1)
		{
			$pages = 1;
		}
		
		return $pages;
		
		
	}
	
	public static function getPostAssocByID($id)
	{
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL AND post = :id";
		
		$where = array
		(
			":id" => $id,
		);
		
		// Získání dat
		$posts = Database::assocAll(Database::query($sql, $where));
		
		// Zpracování a formátování dat
		for($i = 0; $i < count($posts); $i++)
		{
			// Informace o autorovi
			$authorID = $posts[$i]["author"];
			$posts[$i]["user"] = User::getUserByID($authorID, true);
			
			// Formátování data
			$date = new DateTime($posts[$i]["published"]);
			$posts[$i]["published"] =  $date->format('d.m.Y - H:i:s');
		}
		
		// Vrácení dat
		return $posts;		
		
		
		
		
	}
	
	public static function getPostFilesByID($id)
	{
		$sql = "SELECT * FROM viteja_web_posts_files WHERE post = :id";
		
		$where = array
		(
			":id"=>$id,
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		
		if($rows < 1)
		{
			return "empty";
		}
		else
		{
			return Database::assocAll(Database::query($sql, $where));
		}
		
	}

	
	
	
	
}