<?php

namespace App\Views;

use App\Configuration;

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
		$this->twig = new Twig_Environment($this->loader, array($twig_cache));
		
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
		echo self::getInstance()->twig->render($template, $data);
		
	}
	
	
	
	
	
}
