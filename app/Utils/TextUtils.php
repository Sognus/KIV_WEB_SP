<?php

namespace App\Utils;

/*
 * Pomocné metody pro řetězce a text
 */
class TextUtils
{
	
	/*
	 *	Rozdělí řetězec dle zadaného dělícího znaku
	 *	
	 *	Pokud dělící znak neexistuje, vrátí jednoprvkové 
	 *	pole se vstupním rětězcem
	 */
	public static function divide($delimiter, $string)
	{		
		
		if(strpos($string, $delimiter) === false)
		{
			return array($string);
		}
		return explode($delimiter, $string);
		
		
	}
	
	
	
	
}
