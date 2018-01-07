<?php

namespace App\Views;

use App\Configuration;

use App\Models\Auth;
use App\Models\User;

use Twig_Loader_Filesystem;
use Twig_Environment;

class Twig
{
	// Instance jedináčka 
	private static $instance;
	
	// Twig_Loader_Filesystem
	private $loader;
	
	// Twig_Envinroment
	private $twig;
	
	public function __construct()
	{
		echo "<pre>";
		
		$twig_location = __DIR__ . "/../../" . Configuration::get("TWIG_TEMPLATES");
		$twig_cache = __DIR__ . "/../../". Configuration::get("TWIG_CACHE");
		
		$this->loader = new Twig_Loader_Filesystem($twig_location);
		$this->twig = new Twig_Environment($this->loader, array(/* OBNOVIT PRO CACHE 'cache' =>$twig_cache*/));
		
		echo "</pre>";
		
	}
	
	private static function getInstance()
	{
		if(self::$instance == null)
		{
			self::$instance = new self();
		}
		return self::$instance;
		
	}
	
	public static function render($template, $data = array())
	{
		self::refreshSessionRender();
		
		// Pokud soubor existuje, vykresli jeho obsah
		if(file_exists(__DIR__ . "/../../" . Configuration::get("TWIG_TEMPLATES")."/".$template))
		{
			echo self::getInstance()->twig->render($template, $data);
		}
		else
		{
			// Pokud soubor neexistuje, vykresli chybovou hlášku
			Twig::render("error.tpl", array("code"=>"A001", "message"=>"Twig template file does not exist!"));
		}
		
	}
	
	private static function refreshSessionRender()
	{
		$logged = Auth::isLogged();
		if($logged)
		{
			$user = User::getUserByID($_SESSION["user"]["userID"]);
			
			$_SESSION["user"] = array();
			$_SESSION["user"]["userID"] = $user->getID();
			$_SESSION["user"]["userName"] = $user->getNickName();
			$_SESSION["user"]["email"] = $user->getEmail();
			$_SESSION["user"]["accountType"] = $user->getAccountType();
		}
	}
	
	
	
	
	
}
