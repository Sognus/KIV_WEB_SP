<?php

namespace App\Controllers;

use App\Views\Twig;

use App\Models\Post;

class PostController
{
	
	public static function show()
	{
		$data = array();
		$args = func_get_args();
		
		if(isset($args[0]) && is_numeric($args[0]) && $args[0] > 0)
		{
		$posts = Post::getPostAssocByID($args[0]);
		$data["posts"] = $posts;
		$data["files"] = Post::getPostFilesByID($args[0]);
		}
		
		Twig::render("post.tpl", $data);
	}
	
	
}