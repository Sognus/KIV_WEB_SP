<?php

namespace App\Views;

use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{
	/** Složka, ze které načítat tpl soubory */
	private $directory;
	
	private $loader;
	private $twig;
	
	private static $singleton;

	
	private function __construct()
	{	
		$this->directory = null;
		
	}
	
	public static function make($tpl, $array)
	{
		if(self::$singleton == null || self::$singleton->directory == null)
		{
			return;
		}
		
		echo self::$singleton->twig->render($tpl, $array);
		
	} 
	
	public function getResourceDirectory()
	{
		return $this->$dir;
	}
	
	public function setResourceDirectory($directory)
	{
		$this->directory = $directory;
		$this->loader = new Twig_Loader_Filesystem($this->directory);
		$this->twig = new Twig_Environment($this->loader);
	}
	
	public static function setup($dir)
	{
		$singleton = self::getInstance();
		$singleton->setResourceDirectory($dir);
	}

	public static function getInstance()
	{
		if(self::$singleton == null)
		{
			self::$singleton = new self();
		}
		return self::$singleton;
	}	
	
	
	
	
}


