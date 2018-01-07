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
	
	public static function getPostByID($id, $asArr = false)
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
		
		if($asArr)
		{
			return $assoc;
		}
		
		return new self($assoc["post"], $assoc["author"], $assoc["title"], $assoc["text"], $assoc["published"]);
		
		
	}
	
	public static function postExist($id)
	{
		$sql = "SELECT * FROM `viteja_web_posts` WHERE post = :id LIMIT 1";
		
		$where = array
		(
			":id" => $id, 
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		
		if($rows < 1)
		{
			return false;
		}
		
		return true;

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
	
	public static function getAllPostsUser($userID)
	{
		// Dotaz
		$sql = "SELECT * FROM `viteja_web_posts` WHERE author = :author AND state != 'deleted' ORDER BY post DESC";
		
		$where = array
		(
		 ":author" => $userID,
		);
		
		$posts = Database::assocAll(Database::query($sql, $where));
		
		
		// Zpracování a formátování dat
		for($i = 0; $i < count($posts); $i++)
		{
			// Výpočet známky
			$posts[$i]["average"] = self::getPostAverage($posts[$i]["post"]); 
		}	

		return $posts;
		
	}
	
	public static function isPostOwner($post,$who)
	{
		$sql = "SELECT * FROM `viteja_web_posts` WHERE author = :author AND post = :post LIMIT 1";
		
		$where = array
		(
			":author" => $who,
			":post" => $post,
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		
		if($rows > 0)
		{
			return true;
		}
		
		return false;
		
		
	}
	
	public static function setPostStatusByID($id, $status)
	{
		$sql = "UPDATE `viteja_web_posts` SET `state` = :status WHERE `viteja_web_posts`.`post` = :id ;";
		
		$where = array
		(
			":id" => $id,
			":status" => $status,
		);
		
		Database::query($sql, $where);	
		
		if($status == "approved")
		{
			$sql2 = "UPDATE `viteja_web_posts` SET `published` = NOW() WHERE `viteja_web_posts`.`post` = :id ";
			
			$where2 = array
			(
				":id" => $id,
			);
			
			Database::query($sql2, $where2);
		}
		
	}
	
	public static function deletePostByID($id)
	{
		$sql = "UPDATE `viteja_web_posts` SET `state` = 'deleted' WHERE `viteja_web_posts`.`post` = :id ;";
		
		$where = array
		(
			":id" => $id,
		);
		
		
		Database::query($sql, $where);
		
		
	}
	
	public static function getPostAverage($id)
	{
		$sql = 
		"
			SELECT
				viteja_web_reviews.*, viteja_web_users.name as authorName, viteja_web_posts.title, viteja_web_users_alias.name as reviewerName
			FROM
				`viteja_web_reviews`
			INNER JOIN 
				viteja_web_posts ON viteja_web_reviews.post=viteja_web_posts.post
			INNER JOIN 
				viteja_web_users ON viteja_web_posts.author = viteja_web_users.user
			INNER JOIN 
				viteja_web_users_alias ON viteja_web_users_alias.user = viteja_web_reviews.reviewer
			WHERE 
            	viteja_web_reviews.originality != ''
            AND
                viteja_web_reviews.subject != ''
            AND
                viteja_web_reviews.technical != ''
            AND
                viteja_web_reviews.language != ''
			AND
				viteja_web_reviews.deleted = 0
            AND 
            	viteja_web_reviews.post = :id
		";
		
		$where = array
		(
			":id" => $id,
		);
		
		$result = Database::query($sql, $where);
		$rows = Database::numRows($result);
		
		// 3 = minimální počet recenzentů
		if($rows < 1)
		{
			return "Příspěvek zatím nebyl hodnocen";
		}
		
		$assoc = Database::assocAll(Database::query($sql, $where));
		$calcOuter = 0;
		$reviews = 0;
		
		for($i = 0; $i < count($assoc); $i++)
		{
			$reviews++;
			
			$calc = 0;
			
			$calc = $calc + $assoc[$i]["originality"];
			$calc = $calc + $assoc[$i]["subject"];
			$calc = $calc + $assoc[$i]["technical"];
			$calc = $calc + $assoc[$i]["language"];
			
			$calc = $calc / 4;
			 
			
			$calcOuter = $calcOuter + $calc;
		}
		
		return ($calcOuter / $reviews);		
		
		
	}
	
	public static function getPagePosts($page)
	{
		// Dotaz
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL AND state = 'approved' ORDER BY published DESC, post DESC LIMIT :page , :limit";
		
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
		$sql = "SELECT * FROM `viteja_web_posts` WHERE published IS NOT NULL AND state = 'approved' ";
		
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
	
	public static function getAllPostsForAdmin()
	{
		$sql = "
			SELECT viteja_web_posts.*, viteja_web_users.name as authorName
			FROM `viteja_web_posts`
			INNER JOIN viteja_web_users
				ON viteja_web_posts.author = viteja_web_users.user
			WHERE 
				viteja_web_posts.state != 'deleted';
			";
		
		$assoc = Database::assocAll(Database::query($sql));
		
		for($i = 0; $i < count($assoc); $i++)
		{
			$id = $assoc[$i]["post"];
			
			$assoc[$i]["reviewers"] = Review::getReviewersListByPost($id);
			$assoc[$i]["average"] = Post::getPostAverage($id);
						
			for($y = 0; $y < count($assoc[$i]["reviewers"]); $y++)
			{
				$rev = Review::getReviewAverageByID($assoc[$i]["reviewers"][$y]["review"]);
				
					$assoc[$i]["reviewers"][$y]["average"] = $rev;
			
				
			}
					
		}
		
		
		return $assoc;
		
	}
	
	public static function createNewPost($author, $title, $text)
	{
		$sql = 
		"
		INSERT INTO `viteja_web_posts` (`post`, `author`, `title`, `text`, `state`, `published`) VALUES (NULL, :id , :title , :text , 'review', NULL);
		";
		
		$data = array
		(
			":id" => $author,
			":title" => $title,
			":text" => $text,
		);
		
		Database::query($sql, $data);
		
		
	}
	
	public static function postAddFiles($post, $file)
	{
		$sql = 
		"
		INSERT INTO `viteja_web_posts_files` (`post`, `filename`) VALUES ( :post , :file );
		";
		
		$data = array
		(
			":post" => $post,
			":file" => $file,
		);
		
		Database::query($sql, $data);
	}
	
	public static function postRemoveFile($post, $name)
	{
		$sql = 
		"
		DELETE FROM `viteja_web_posts_files` WHERE `viteja_web_posts_files`.`post` = :post AND LOWER(`viteja_web_posts_files`.`filename`) = LOWER( :name );
		";
		
		$where = array
		(
			":post" => $post,
			":name" => $name,
		);
		
		Database::query($sql, $where);
	}
	
	public static function updatePost($postID, $title, $text)
	{
		$sql = 
		"
		UPDATE viteja_web_posts 
		SET
			title = :title,
			text = :text
		WHERE
			`viteja_web_posts`.`post` = :id
		";
		
		// Where + data
		$whta = array
		(
			":title" => $title,
			":text" => $text,
			":id" => $postID,
		);
		
		Database::query($sql, $whta);
	}

	
	
	
	
}