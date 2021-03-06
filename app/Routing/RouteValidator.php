<?php

namespace App\Routing;

use App\Utils\TextUtils;

/**

	Třída, která zpracuje vstupní URL 
	a následně dovolí validovat jednotlivé
	Routy vůči zpracované URL

	TODO:
		Přidat filtrování typu
			uzivatel/{username}, array("string")
			uzivatel/{userID}, array("int")
	
	@author Jakub Vítek

*/
class RouteValidator
{
		/** Nezpracovaná vstupní URL  */
		private $raw;
		
		/** Zpracovaná vstupní URL */
		private $parsed;
		
		/** Wildcard proměnné */
		private $wildcard;
		
		/** Konstruktor - přijímá URL ke zpracování */
		public function __construct($raw)
		{
			$this->raw = $raw;
			
			$this->parse();
		}
		
		public function getWildcard()
		{
			if($this->wildcard == null)
			{
				return array();
			}
			return $this->wildcard;
			
			
		}
		
		/** 
		*	Validace Routy vůči aktuálnímu URL
		*		Vrací true když URL odpovídá routě
		*		Vrací false když URL neodpovídá routě
		*/
		public function validate($route, $types = array())
		{				
			// Typ uživatelem zadané URL a routy je rozdílný
			if(!$this->isTypeSame($route))
			{
				return false;
			}
			
			// Typ URL je stejný, ověřuji na základě typu 
			if($this->isModernURL())
			{
				return $this->validateModern($route, $types);	
			}
			else
			{
				return $this->validateBasic($route, $types);
			}
			
		
		}
		
		/**
		*
		*	Ověří zda raw URL je stejného typu jako route s wildcard 
		*
		*/
		private function isTypeSame($route)
		{			
			$raw_modern = $this->isModernURL();
			$route_modern = $this->isModernURL($route);
			$status = $raw_modern === $route_modern;
			
			// Operátor ===: oba výroky true nebo oba false
			if($status)
			{
				return true;
			}
			return false;
			
			
		}
		
		/**
		*	Vytvoří pole hodnot wildcard - Modern URL
		*
		*		/uzivatel/{username} => /uzivatel/viteja => array("username" => "viteja")
		*
		*/		
		private function parseWildcard($route)
		{		
			// Rozdělí cesty dle separátoru cesty, vyfiltruje prázdné hodnoty a seřadí pole dle hodnot
			$route_parts = array_values(array_filter(array_map('trim', explode("/", $route))));
			$raw_parts = array_values(array_filter(array_map('trim', explode("/", $this->raw))));;
			
			// Připraví klíče wildcard pole tak, že odstraní znaky {}
			$search = array("{", "}");
			$replace = "";
			
			for($i = 0; $i < count($route_parts); $i++)
			{
				$route_parts[$i] = str_replace($search, $replace, $route_parts[$i]);
			}
			
			// Spojí pole
			$this->wildcard = array_combine($route_parts, $raw_parts);
			
		}
		
		/**
		*	Vytvoří pole hodnot wildcard - Modern URL
		*
		*		index.php?page=uzivatel&username={username} => index.php?page=uzivatel&username=viteja => array("username" => "viteja");
		*
		*/	
		private function parseBasicWildcard($route)
		{			
			parse_str(parse_url($route, PHP_URL_QUERY), $route_query);
			parse_str(parse_url($this->raw, PHP_URL_QUERY), $raw_query);
			
			$keys = array_keys($route_query);
			$vals = array_values($raw_query);
			
			$this->wildcard = array_combine($keys, $vals);
			
		}
		
		
		
		/** 
		*	Validuje routu vůči url typu index.php?page=..
		*/
		private function validateBasic($route, $types = array())
		{
			
			$route = $this->parseBasicRoute($route);
									
			// Změna {cokoliv} na *
			$pattern_wildcard = preg_replace("/\{(.*?)\}/", "*", $route);
			
			// Ověření zda vstup i pattern odpovídají a jsou ve stejném tvaru
			$pattern_wildcard_status = fnmatch($pattern_wildcard, $this->parsed) ? true : false;
			
			// Pattern nesedí, je zbytečné kontrolovat zbytek
			if(!$pattern_wildcard_status)
			{
				return false;
			}
			
			// Ověří zda vstupní proměnné jsou správného typu
			// Pokud typy nejsou zadány, automaticky se předpokládá string
			parse_str($this->parsed, $parsed_parts);
			
			if(count($types ) < 1)
			{
				$desired_count = count($parsed_parts);
				
				for($oo = 0; $oo < $desired_count; $oo++)
				{
					$types[$oo] = "string";
				}
				
			}
			
			// Pole s typy není stejně velké jako počet proměnných
			if(count($types) != count($parsed_parts))
			{
				return false;
			}
			
				
			// Zahození associativních indexů
			$parsed_parts = array_values($parsed_parts);
			
				
			// Ověřuje zda všechny proměnné, co mají být numerické opravdu numerickou jsou
			for($i = 0; $i < count($types); $i++)
			{
				
				//echo "TYPES VS PARSED = ".$types[$i]." VS ".$parsed_parts[$i]."<br>";
					
				if($types[$i] == "int" && !is_numeric($parsed_parts[$i]))
				{
						 // Proměnná není číslem, ale měla by být
						 return false;
				}
				
				if($types[$i] == "string" && is_numeric($parsed_parts[$i]))
				{
						 // Proměnná je číslem ale neměla by být
						 return false;
				}
			}
			
			
			// Uložení proměnných získaných z wildcard
			parse_str($route, $wildcard_names);
			
			$findWLC = ["{", "}"];
			$valueWLC = array_values($wildcard_names);
			
			for($q = 0; $q < count($valueWLC); $q++)
			{
				
				if(strpos($valueWLC[$q], "{") !== false && strpos($valueWLC[$q], "}" ) !== false)
				{
					$key = str_replace($findWLC, "", $valueWLC[$q]);
					$this->wildcard[$key] = $parsed_parts[$q];
				}
			
			}
				
			return true;
				

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
			
			return $prepared_pattern;
			
		}
		
		private function validateModern($route, $types = array())
		{
			
			
			
			// Zvláštní chování kořenového nodu
			if($this->raw == "/" || $route == "/")
			{
				// Rovná se routa kořenovému nodu?
				$yrn = ($this->raw == $route);				
				return $yrn;
			}
						
			// Změna {cokoliv} na *
			$pattern_wildcard = preg_replace("/\{(.*?)\}/", "*", $route);
			$pattern_wildcard_parts = TextUtils::divide("/", trim($pattern_wildcard, "/"));
			
			$route_parts = TextUtils::divide("/", trim($this->raw, "/"));
			
			// Routa má stejný počet zanoření jako URL
			if(count($pattern_wildcard_parts) != count($route_parts))
			{
				// Nemá
				return false;
			}
			
			// Zjištění počtu wildcard
			$pocetWLC = 0;
			for($i = 0; $i < count($pattern_wildcard_parts); $i++)
			{
				if($pattern_wildcard_parts[$i] == "*")
				{
					$pocetWLC++;
				}
			}
			
			
			// Pokud typy nebyly zadány, použijí se řetězce
			if(count($types) < 1)
			{
				$types = array_fill(0, $pocetWLC, "string");
			}
			
			// Ověření počtu typů
			if(count($types) != $pocetWLC)
			{
				// Špatně definovaná routa (méně nebo více typů)
				return false;
			}
			
			// Parsování wildcard formátu pro jména wildcard
			$wildcardVals = TextUtils::divide("/", trim($route, "/"));
			
			
			// Ověření typů wildcard
			$poradiWLC = 0;
			for($i = 0; $i < count($pattern_wildcard_parts); $i++)
			{
				if($pattern_wildcard_parts[$i] == "*")
				{
					$overWLC = $route_parts[$i];
					$typ = $types[$poradiWLC];
					$key = $wildcardVals[$i];
					
					
					if($typ == "string" && is_numeric($overWLC))
					{
						// Číselná cesta = špatně
						return false;
					}
					
					if($typ == "int" && !is_numeric($overWLC))
					{
						// Nečíselná cesta = špatně
						return false;
					}
					
					// Vyhovuje typování
					$this->wildcard[$key] = $overWLC;
					
					
				}
				else
				{
					if($route_parts[$i] != $pattern_wildcard_parts[$i] )
					{
						// Část, která není wildcard nevyhovuje
						return false;
					}
				}
			}
		
			
			// Vše v pořádku
			return true;
			
			
			
			
			
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
		private function isModernURL($text = "")
		{		
			$text = $text == "" ? $this->raw : $text;
			
			
			if(strpos($text, "?") || strpos($text, "."))
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