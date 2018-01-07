<?php

namespace App\Controllers;

use App\Routing\Route;
use App\Views\Twig;

use App\Models\Auth;
use App\Models\User;
use App\Models\Review;
use App\Models\Post;

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
			case "reviews":
				$template = "admin-reviews.tpl";
				$data["reviews"] = Review::getReviewList();				
				
				/*
				echo "<pre>";
				print_r($data);
				echo "</pre>";
				die();
				//*/
				
				break;
			case "posts":
				$template = "admin-posts.tpl";
				$data["posts"] = Post::getAllPostsForAdmin();
				$data["reviewers"] = Review::getReviewersList();	
	
				/*
				echo "<pre>";
				print_r($data);
				echo "</pre>";
				die();
				//*/
				
				break;
			default:
				$template = "admin.tpl";		
		}
		
		// Vykreslení stránky
		Twig::render($template, $data);
		
		
	}
	
	public static function post()
	{
		$sender = User::getUserByID($_SESSION["user"]["userID"]);
		$logged = $sender !== null && $sender->getAccountType() == 2;
		
		if(isset($_POST) && $logged)
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
			
			if(isset($_POST["user-ban"]))
			{
				User::banUserByID($_POST["user-ban"]);
			}
			
			if(isset($_POST["user-unban"]))
			{
				User::unbanUserByID($_POST["user-unban"]);
			}
			
			if(isset($_POST["user-delete"]))
			{
				User::deleteUserByID($_POST["user-delete"]);
			}
				
			
			if(isset($_POST["review-delete"]))
			{
				Review::deleteReviewByID($_POST["review-delete"]);
			}
			
			if(isset($_POST["posts-new-reviewer"]))
			{				
				$postID = $_POST["posts-new-reviewer"];
				$rewID = $_POST["post-new-reviewer-select"];
								
				Review::createNew($postID, $rewID);
			}
			
			if(isset($_POST["post-reviewer-remove"]))
			{
				$rewID = $_POST["post-reviewer-remove"];
				$postID = $_POST["post-reviewer-remove-post"];
				
				Review::deleteReview($postID, $rewID);
			}
			
			if(isset($_POST["post-delete"]))
			{
				$id = $_POST["post-delete"];
				
				Post::deletePostByID($id);
			}
			
			if(isset($_POST["post-reject"]))
			{
				$id = $_POST["post-reject"];
				
				Post::setPostStatusByID($id, "rejected");
				
			}
			
			if(isset($_POST["post-approve"]))
			{
				$id = $_POST["post-approve"];
				
				Post::setPostStatusByID($id, "approved");
			}
			
			unset($_POST);
			
		}
		
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
			case "reviews":
				$template = "admin-reviews.tpl";
				$data["reviews"] = Review::getReviewList();				
				break;
			case "posts":
				$template = "admin-posts.tpl";
				$data["posts"] = Post::getAllPostsForAdmin();
				$data["reviewers"] = Review::getReviewersList();
				break;
			default:
				$template = "admin.tpl";		
		}
		
		// Vykreslení stránky
		Twig::render($template, $data);
		
		
	}
	
}