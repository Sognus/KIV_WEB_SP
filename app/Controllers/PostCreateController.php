<?php

namespace App\Controllers;

use App\Database;
use App\Views\Twig;

use App\Models\Post;

class PostCreateController
{
	
	public static function show()
	{
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		
		Twig::render("post-create.tpl", $data);
		
	}
	
	public static function post()
	{
		$data = array();
		$data["session"] = $_SESSION;
		$args = func_get_args();
		
		
		if(isset($_POST["post-create"]))
		{	
			// Základní ošetření, vytažení dat z _POST
			foreach($_POST as $key => $value)
			{
				${$key} = htmlspecialchars(trim($value));
				$_POST[$key] = htmlspecialchars(trim($value));
			}

			// Jednopruchodový cyklus pro cheatování code-blocku, ze kterého lze odejít přes break
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
								
				// TODO: Vložení nového příspěvku
				Post::createNewPost($_SESSION["user"]["userID"], $_POST["post-create-nazev"], $_POST["post-create-text"]);
				$id = Database::lastInsertID();
				
				if($id == 0)
				{
					$data["error"] = "Nepodařilo se vložit příspěvek do databáze!";
					break;
				}
				
				// Zpracování všech souborů
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

									Post::postAddFiles($id, $longName);
								}
							  }
						}
				 }
				
			
			}
			while(false); // Jednopruchodový cyklus pro cheatování code-blocku, ze kterého lze odejít přes break

			
		}
		
		
		Twig::render("post-create.tpl", $data);
		
	}
	
	
}