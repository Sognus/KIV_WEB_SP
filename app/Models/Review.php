<?php

namespace App\Models;

use App\Database;
use App\Configuration;


class Review
{
	
	// DAO vlastnosti
	private $id;
	private $post;
	private $reviewer;
	private $originality;
	private $subject;
	private $technical;
	private $language;
	private $note;
	
	// Konstruktor
	private function __construct($id, $post, $reviewer, $originality, $subject, $technical, $language, $note)
	{
		
		$this->id = $id;
		$this->post = $post;
		$this->reviewer = $reviewer;
		$this->originality = $originality;
		$this->subject = $subject;
		$this->technical = $technical;
		$this->language = $language;
		$this->note = $note;
		
		
		
	}
	
	// Gettery
	public function getID()
	{
		return $this->id;
	}
	
	public function getPostID()
	{
		return $this->post;
	}
	
	public function getReviewerID()
	{
		return $this->reviewer;
	}
	
	public function getOriginality()
	{
		return $this->originality;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function getTechnical()
	{
		return $this->technical;
	}
	
	public function getLanguage()
	{
		return $this->language;
	}
	
	public function getNote()
	{
		return $this->getNote;
	}
	
	// Výpočet průměru
	public function getAverage()
	{
		$error = false;
		$calc = 0;
		
		if(in_array($this->getOriginality(), array("1","2","3","4","5", 1, 2,3,4,5)))
		{
			$calc = $calc + $this->getOriginality();
		}
		else
		{
			$error = true;
		}
		
		if(in_array($this->getSubject(), array("1","2","3","4","5", 1, 2,3,4,5)))
		{
			$calc = $calc + $this->getSubject();
		}
		else
		{
			$error = true;
		}
		
		if(in_array($this->getLanguage(), array("1","2","3","4","5", 1, 2,3,4,5)))
		{
			$calc = $calc + $this->getTechnical();
		}
		else
		{
			$error = true;
		}
		
		if(in_array($this->getLanguage(), array("1","2","3","4","5", 1, 2,3,4,5)))
		{
			$calc = $calc + $this->getTechnical();
		}
		else
		{
			$error = true;
		}
		
		if($error === true)
		{
			return 0;
		}
		else
		{
			$calc = $calc/4;
		}
		
		
	}
	
	public static function getReviewByID($id, $asArr = false)
	{
		$sql = "SELECT * FROM `viteja_web_reviews` where review = :id LIMIT 1";
		
		$where = array
		(
			":id" => $id,
		);
		
		$res = Database::query($sql, $where);
		$num = Database::numRows($res);
		
		if($num < 1)
		{
			return null;
		}
		
		$assoc = Database::assoc($res);
				
		if($asArr)
		{
			return $assoc;
		}
				
		return new self($assoc["review"], $assoc["post"], $assoc["reviewer"], $assoc["originality"], $assoc["subject"], $assoc["technical"], $assoc["language"], $assoc["note"]);
		
	}
	
	public static function getReviewAverageByID($id)
	{
		$sql = "SELECT * FROM `viteja_web_reviews` where review = :id LIMIT 1";
		
		$where = array
		(
			":id" => $id,
		);
		
		$res = Database::query($sql, $where);
		$num = Database::numRows($res);
		
		if($num < 1)
		{
			return null;
		}
		
		$assoc = Database::assoc($res);
		
		@$calc = 0;
		@$calc = $calc + $assoc["originality"];
		@$calc = $calc + $assoc["subject"];
		@$calc = $calc + $assoc["technical"]; 
		@$calc = $calc + $assoc["language"];
		
		@$calc = $calc / 4;
		
		return $calc;
		
	}
	
	public static function getReviewList()
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
				viteja_web_reviews.deleted = 0
		";
		
		$assoc = Database::assocAll(Database::query($sql));
		
		for($i = 0; $i < count($assoc); $i++)
		{
			$calc = 0;
			
			@$calc = $calc + $assoc[$i]["originality"];
			@$calc = $calc + $assoc[$i]["subject"];
			@$calc = $calc + $assoc[$i]["technical"];
			@$calc = $calc + $assoc[$i]["language"];
			
			@$calc = $calc / 4;
			
			$assoc[$i]["average"] =  $calc;
		}
		
		
		return $assoc;
	
	}
	
	
	public static function deleteReviewByID($id)
	{
		$sql = "UPDATE `viteja_web_reviews` SET `deleted` = '1' WHERE `viteja_web_reviews`.`review` = :id ;";
		
		$where = array
		(
		 ":id" => $id,
		);
		
		Database::query($sql, $where);
	}
	
	public static function getReviewersList()
	{
		$sql = "SELECT * FROM `viteja_web_users` where account >= '1';";
		
		return Database::assocAll(Database::query($sql));		
		
		
	}
	
	public static function getReviewersListByPost($id)
	{
		$sql =
		"
		SELECT viteja_web_reviews.*, viteja_web_users.name as authorName, viteja_web_posts.title, viteja_web_users_alias.name as reviewerName FROM `viteja_web_reviews` INNER JOIN viteja_web_posts ON viteja_web_reviews.post=viteja_web_posts.post INNER JOIN viteja_web_users ON viteja_web_posts.author = viteja_web_users.user INNER JOIN viteja_web_users_alias ON viteja_web_users_alias.user = viteja_web_reviews.reviewer WHERE viteja_web_posts.post = :postID AND viteja_web_reviews.deleted != 1 GROUP BY  reviewerName
		";
		
		$where = array
		(
			":postID" => $id,
		);
		
		$assoc = Database::assocAll(Database::query($sql, $where));
		
	
		return $assoc;
	}
	
	public static function createNew($postID, $reviewerID)
	{
		$sql = 
		"
		INSERT INTO `viteja_web_reviews` (`review`, `post`, `reviewer`, `originality`, `subject`, `technical`, `language`, `note`, `deleted`)
		VALUES (NULL, :postID , :reviewerID , '', '', '', '', '', '0');
		";
		
		$data = array
		(
			":postID" => $postID,
			":reviewerID" => $reviewerID,
		);
		
		
		$sql2 =
		"
		SELECT * FROM `viteja_web_reviews` 
		WHERE 
			post = :postID
		AND
			reviewer = :reviewerID
		AND 
			deleted = '0'
		";
		
		$rs2 = Database::query($sql2, $data);
		$nr2 = Database::numRows($rs2);
				
		if($nr2 < 1)
		{
		Database::query($sql, $data);
		}
	}
	
	public static function deleteReview($postID, $rewID)
	{
		$sql =
		"
		UPDATE `viteja_web_reviews` SET `deleted` = '1' 
		WHERE 
			`viteja_web_reviews`.`post` = :postID 
		AND 
			`viteja_web_reviews`.`reviewer` = :rewID ;
		";
		
		$where = array
		(
		 ":postID" => $postID,
		 ":rewID" => $rewID,
		);
		
		Database::query($sql,$where);
		
	}
	
	public static function getReviewListByPost($id)
	{
		$sql = "
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
            	viteja_web_posts.post = :postID ;";
				
		$where = array
		(
			":postID" => $id,
		);
		
		return Database::assocAll(Database::query($sql, $where));
		
	}
	
	public static function isReviewer($revID, $user)
	{
		$sql = 
		"
		SELECT * FROM `viteja_web_reviews` WHERE `review` = :revID AND `reviewer`= :user AND deleted = 0
		";
		
		$where = array
		(
			":revID" => $revID,
			":user" => $user,
		);
		
		$result = Database::query($sql, $where);
		$num = Database::numRows($result);
		
		if($num > 0)
		{
			return true;
		}

		
		return false;
		
		
	}
	
	public static function doReview($revID, $originality, $subject, $technical, $language)
	{
		$sql =
		"
		UPDATE `viteja_web_reviews` 
		SET 
			`originality` = :orig ,
			`subject` = :sub ,
			`technical` = :tech ,
			`language` = :lang
		WHERE `viteja_web_reviews`.`review` = :revID
		";
		
		// Where + data
		$whta = array
		(
			":orig" => $originality,
			":sub" => $subject,
			":tech" => $technical,
			":lang" => $language,
			":revID" => $revID
		);
		
		Database::query($sql, $whta);
		
	}

	
}