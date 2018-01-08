<?php

namespace App\Controllers;

use App\Views\Twig;

use App\Models\User;
use App\Models\Post;
use App\Models\Review;

use App\Routing\Route;

class ReviewerController
{
	
	public static function show()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		
		Twig::render($template, $data);		
	}
	
	public static function post()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		
		Twig::render($template, $data);		
	}
	
	public static function listShow()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer-list.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		$who = $_SESSION["user"]["userID"];
		
		// Data
		$data["posts"] = Post::getReviewerPosts($who);
		
		Twig::render($template, $data);		
	}
	
	public static function listPost()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer-list.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		
		Twig::render($template, $data);		
	}
	
	public static function reviewShow()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer-edit.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		$user = $_SESSION["user"]["userID"];
		
		$revID = isset($args[0]) && !empty($args[0]) ? $args[0] : 0;
		
		if($revID == 0 || !Review::isReviewer($revID, $user))
		{
			$data["error"] = "Tato recenze neexistuje nebo nesouvisí s Vaším účtem!";
		}
		else
		{
			$postID = Post::getPostIDByReview($revID);
			
			if($postID == 0 || !Post::postExist($postID))
			{
				$data["error"] = "Recenze odkazuje na špatný příspěvek!";
			}
			else
			{
				$data["post"] = Post::getPostByID($postID, true);
				$data["files"] = Post::getPostFilesByID($postID);
				$data["review"] = $revID;
				$data["reviewData"] = Review::getReviewByID($revID, true);
				
			}
		}
		
		Twig::render($template, $data);				
	}
	
	public static function reviewPost()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]) || !User::isReviewer($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		$template = "reviewer-edit.tpl";
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		$user = $_SESSION["user"]["userID"];
	
		$revID = isset($args[0]) && !empty($args[0]) ? $args[0] : 0;
	
	
		if($revID == 0 || !Review::isReviewer($revID, $user))
		{
			$data["error"] = "Tato recenze neexistuje nebo nesouvisí s Vaším účtem!";
		}
		else
		{
			
			// Základní ošetření, vytažení dat z _POST
			foreach($_POST as $key => $value)
			{
				${$key} = htmlspecialchars(trim($value));
				$_POST[$key] = htmlspecialchars(trim($value));
			}
			
			// Post události
			
			if(isset($_POST["review-confirm"]))
			{
				$orig = $_POST["review-originality"];
				$subj = $_POST["review-subject"];
				$tech = $_POST["review-technical"];
				$lang = $_POST["review-language"];
				
				Review::doReview($revID, $orig, $subj, $tech, $lang);
			}

			// end post události
			
			$postID = Post::getPostIDByReview($revID);
			
			if($postID == 0 || !Post::postExist($postID))
			{
				$data["error"] = "Recenze odkazuje na špatný příspěvek!";
			}
			else
			{
				$data["post"] = Post::getPostByID($postID, true);
				$data["files"] = Post::getPostFilesByID($postID);
				$data["review"] = $revID;
				$data["reviewData"] = Review::getReviewByID($revID, true);
				
				
			}
		}
		
		Twig::render($template, $data);			
	}
	
	
	
	
}