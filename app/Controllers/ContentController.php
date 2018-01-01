<?php

namespace App\Controllers;

use App\Views\Twig;

use App\Models\Post;

class ContentController
{
	
	public static function show()
	{
		$args = func_get_args();
		
		$data = array();
		$data["session"] = $_SESSION;
		
		// Získá příspěvky z databáze
		$currentPart = isset($args[0]) ? $args[0] : 1;
		$showPage = (isset($args[0]) && $args[0] > 0) ? $args[0] : 1;
		$posts = Post::getPagePosts($showPage);
		
		$data["posts"] = $posts;
		$data["stran"] = Post::getPageCount();
		$data["currentPage"] = $currentPart;

		Twig::render("content.tpl", $data);
	}
	
	
	
	
	
	
}