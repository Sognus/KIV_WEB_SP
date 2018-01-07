<?php
namespace App\Controllers;

use App\Views\Twig;
use App\Routing\Route;

use App\Models\Post;
use App\Models\User;

class UserController
{
	
	public static function show()
	{
		$template = "user.tpl";
		$args = func_get_args();
		$data = array();
		$data["session"] = $_SESSION;
		
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}		
		
		// Rozhodnutí template, která se má načíst
		$part = isset($args[0]) ? $args[0] : "none";
		
		switch($part)
		{
			case "posts":
				$template = "user-posts.tpl";
				$data["posts"] = Post::getAllPostsUser($_SESSION["user"]["userID"]);
				break;
			default:
				$template = "user.tpl";
		}
		
		
		Twig::render($template, $data);
		
		
		
	}
	
	public static function post()
	{
		
		$template = "user.tpl";
		$args = func_get_args();
		$data = array();
		$data["session"] = $_SESSION;
		
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}

		// Akce Post
		
		// Základní ošetření, vytažení dat z _POST
		foreach($_POST as $key => $value)
		{
			${$key} = htmlspecialchars(trim($value));
			$_POST[$key] = htmlspecialchars(trim($value));
		}
		
		if(isset($_POST["post-delete-user"]))
		{
			$who = $_SESSION["user"]["userID"];
			$target = $_POST["post-delete-user"];
			
			$canDelete = Post::isPostOwner($target, $who) || User::isAdministrator($who);
			
			if($canDelete)
			{
				Post::deletePostByID($target);
			}
			
		}
		
		
		// Rozhodnutí template, která se má načíst
		$part = isset($args[0]) ? $args[0] : "none";
		
		switch($part)
		{
			case "posts":
				$template = "user-posts.tpl";
				$data["posts"] = Post::getAllPostsUser($_SESSION["user"]["userID"]);
				break;
			default:
				$template = "user.tpl";
		}
		
		
		Twig::render($template, $data);
	}
	
	public static function editShow()
	{
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		
		$template = "user-edit.tpl";
		$args = func_get_args();
		$data = array();
		$data["session"] = $_SESSION;
		$who = $_SESSION["user"]["userID"];
		
		$postID = isset($args[0]) && !empty($args[0]) ? $args[0] : 0;
		
		if($postID == 0 || !Post::postExist($postID) || !Post::isPostOwner($postID,$who))
		{
			$data["error"] = "Tento příspěvek neexistuje nebo k němu nemáte práva!";
		}
		else
		{
			$data["post"] = Post::getPostByID($postID, true);
			$data["files"] = Post::getPostFilesByID($postID);
		}
		
		Twig::render($template, $data);
	}
	
	public static function editPost()
	{
			
		// Ověření uživatelských práv
		if(!isset($_SESSION["user"]["userID"]))
		{
			Route::error(403);
			die();
		}
		
		// Základní ošetření, vytažení dat z _POST
		foreach($_POST as $key => $value)
		{
			${$key} = htmlspecialchars(trim($value));
			$_POST[$key] = htmlspecialchars(trim($value));
		}

		$template = "user-edit.tpl";
		$args = func_get_args();
		$data = array();
		$data["session"] = $_SESSION;
		$who = $_SESSION["user"]["userID"];

		$postID = isset($args[0]) && !empty($args[0]) ? $args[0] : 0;
		
		if(isset($_POST["post-edit-file-remove"]))
		{
			$filename = $_POST["post-edit-file-remove"];
			
			if($postID == 0)
			{
				// Nedělej nic, možná error výpis
			}
			else
			{
				Post::postRemoveFile($postID, $filename);
			}
			
		}
		
		if(isset($_POST["post-edit"]))
		{
					
			if($postID == 0)
			{
				// Nedělej nic
			}
			else
			{
				do
				{
					if(empty($_POST["post-create-nazev"]) || $_POST["post-create-nazev"] == "")
					{
						$err = true;
						$data["error"] = "Je vyžadován název příspěvku!";
						break;
					}
					
					if(empty($_POST["post-create-text"]) || $_POST["post-create-text"] == "")
					{
						$err = true;
						$data["error"] = "Je vyžadován text příspěvku!";
						break;
					}
					
					Post::updatePost($postID, $_POST["post-create-nazev"], $_POST["post-create-text"]);
					$data["success"] = "Příspěvek byl změněn!";
					
				
					// Zpracování všech nových souborů
					 if(count($_FILES['upload']['name']) > 0){
							// Zpracování každého souboru
							for($i=0; $i<count($_FILES['upload']['name']); $i++) {
							  // Získání dočasné cesty
								$tmpFilePath = $_FILES['upload']['tmp_name'][$i];

								// Ošetření 
								if($tmpFilePath != ""){
								
									// Jméno soubnoru
									$shortname = $_FILES['upload']['name'][$i];

									// Vytvoření jména
									$longName = $_SESSION["user"]["userID"] .'-'. date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
									
									// Vytvoření cesty
									$filePath = "upload/" . $longName;  

									// Nahrání souboru do cílobé složky
									if(move_uploaded_file($tmpFilePath, $filePath)) {

										$files[] = $shortname;
										 
										//$shortname - jméno souboru
										//$filePath - relativní cesta k souboru

										Post::postAddFiles($postID, $longName);
									}
								  }
							}
					 }
					 
					 // 
					 
				}while(false);
			}
		}
		

		

		
		if($postID == 0 || !Post::postExist($postID) || !Post::isPostOwner($postID,$who))
		{
			$data["error"] = "Tento příspěvek neexistuje nebo k němu nemáte práva!";
		}
		else
		{
			$data["post"] = Post::getPostByID($postID, true);
			$data["files"] = Post::getPostFilesByID($postID);
		}
		
		Twig::render($template, $data);
		
	}
	
	
	
}