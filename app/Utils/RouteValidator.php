<?php

namespace App\Utils;

/**

	Třída, která zpracuje vstupní URL 
	a následně dovolí validovat jednotlivé
	Routy vůči zpracované URL

	@author Jakub Vítek

*/
class RouteValidator
{
		/** Nezpracovaná vstupní URL  */
		private $raw;
		
		/** Zpracovaná vstupní URL */
		private $parsed;
		
		/** Konstruktor - přijímá URL ke zpracování */
		public function __construct($raw)
		{
			$this->raw = $raw;
			
			$this->parse();
		}
		
		/** 
		*	Validace Routy vůči aktuálnímu URL
		*		Vrací true když URL odpovídá routě
		*		Vrací false když URL neodpovídá routě
		*/
		public function validate($route)
		{
			if($this->isModernURL())
			{
				return $this->validateModern($route);
				
			}
			else
			{
				return $this->validateBasic($route);
			}
		}
		
		/** 
		*	Validuje routu vůči url typu index.php?page=..
		*/
		private function validateBasic($route)
		{
			$route = $this->parseBasicRoute($route);
						
			// Změna {cokoliv} na *
			$pattern_wildcard = preg_replace("/\{(.*?)\}/", "*", $route);
			
			// Ověření zda vstup i pattern odpovídají a jsou ve stejném tvaru
			$pattern_wildcard_status = fnmatch($pattern_wildcard, $this->parsed) ? true : false;
			
			return $pattern_wildcard_status;	
			}
		
		private function parseBasicRoute($route)
		{
			$pattern = $route;
			
	
			// Získání QUERY STRING části patternu
			$pattern_query = parse_url($pattern, PHP_URL_QUERY);
				
			// Zpracování QUERY STRING řetězce a jeho seřazení
			parse_str($pattern_query, $pattern_query_parsed);
			ksort($pattern_query_parsed);
					
			// Vytvoření query a nahrazení rozbitých znaků {} správnými
			$prepared_pattern = http_build_query($pattern_query_parsed);
					
			$prepared_pattern_from = array("%7B", "%7D");
			$prepared_pattern_to = array("{", "}");
			$prepared_pattern = str_replace($prepared_pattern_from, $prepared_pattern_to, $prepared_pattern);
			
			// Ujištění, že každý modern pattern začíná a končí separátorem složky
			$prepared_pattern = $prepared_pattern[0] == "/" ?  $prepared_pattern : "/" . $prepared_pattern;
			$prepared_pattern = $prepared_pattern[strlen($prepared_pattern)-1] == "/" ? $prepared_pattern : $prepared_pattern ."/";
			
			return $prepared_pattern;
			
		}
		
		/** 
		*	Validuje routu vůči url typu index.php?page=..
		*/
		private function validateModern($route)
		{
			// Změna {cokoliv} na *
			$pattern_wildcard = preg_replace("/\{(.*?)\}/", "*", $route);
			
			// Ověření zda vstup i pattern odpovídají a jsou ve stejném tvaru
			$pattern_wildcard_status = fnmatch($pattern_wildcard, $this->parsed) ? true : false;
			
			// Ověření zda vstup i pattern mají stejně parametrů
			$parsed_argc = count(explode("/", trim($this->parsed, "/" )));
			$route_argc = count(explode("/", trim($route, "/" )));
			
			// Návrat na základě validaci URL proti patternu při stejném počtu parametrů
			if($pattern_wildcard_status)
			{
				if($parsed_argc == $route_argc)
				{
					return true;
				}
			}
			return false;
			
		}
		
		
	
		/** Na základě typu URL zpracuje danou URL pro účely validace */
		private function parse()
		{
			
			if($this->isModernURL())
			{
				$this->parseModernURL();
			}
			else
			{
				$this->parseURL();
			}
			
		}
		
		/** Určí zda se jedná o moderní URL */
		private function isModernURL()
		{
			if(strpos($this->raw, "?") || strpos($this->raw, "."))
			{
				return false;
			}
			else
			{
				return true;
			}
			
		}
		
		
		private function parseModernURL()
		{
			$this->parsed = $this->raw;
		}
		
		/** Zpracuje URL staršího typu */
		private function parseURL()
		{
			// Získání cesty bez nadřazených složek 
			$basename = basename($this->raw);
			// Odstranění nadřazených složek (čeština-vzdorné)
			$input = substr($this->raw, strpos($this->raw, $basename), strlen($this->raw));
			// Získání QUERY části z URL
			$query = parse_url($input, PHP_URL_QUERY);
			// Převod QUERY části na asociativní pole
			parse_str($query, $query_parts);
			// Seřazení daného pole podle klíčů
			ksort($query_parts);
			// Vytvoření zpracované QUERY části 
			$query_parsed = $this->buildQuery($query_parts);
			// Vytvoření zpracované basename URL
			$query_completed = rtrim(substr($basename, 0, strpos($basename,"?")) . "?" . $query_parsed, "?");
			// Odstraní výskyt index.php? pokud existuje
			$query_completed = strpos($query_completed, "index.php?") === false ? $query_completed : str_replace("index.php?", "", $query_completed);
			// Uložení zpracované cesty
			$this->parsed = $query_completed;
		}
		
		/** Serializuje seřazené části na formát http query; */
		private function buildQuery($query_parts)
		{
			$rtn = "";
			
			$keys = array_keys($query_parts);
			$last = end($keys);
			
			foreach($query_parts as $key=>$value)
			{
				$rtn .= ($key === $last ) ? sprintf("%s=%s", $key, $value) : sprintf("%s=%s&", $key, $value);
			}
			
			return $rtn;
		}
		
		
		

	
	
	
	
	
	
}