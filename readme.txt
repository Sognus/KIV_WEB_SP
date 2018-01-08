SOUBORY A ADRESÁŘE:
	<root>
		.git				- složka pro Github
		
		app					- složka s logikou a řízením aplikace
			Controllers		- Složka s kontrolery aplikace
			Models			- Složka s modely aplikace
			Routing			- Složka se zdrojovým kódem pro routovací systém aplikace
			Utils			- Složka s náhodnými třídami, které se jinam nevešly
			Views			- Složka se třídami zajišťující vykreslení šablon
			
		resources			- složka s šablonami, scripty, styly
			css				- kaskádové styly aplikace, CSS "knihovny"
			json			- javascript aplikace, JS knihovny
			lang			- nevyužitá složka
			vendor			- důležitější knihovny, které mají CSS i JS
			views			- Twig šablony
			
		routes				- složka se soubory definující použitelné url aplikace
			web.php			- soubor s definicí routes
		
		upload				- složka pro data nahrána uživateli
		
		vendor				- složka pro composer a jím vyžadované knihovny
		
		.htaccess			- soubor definující přesměrování všech volání na index.php
		composer.json		- soubor definující projekt a vyžadované knihovny pro composer
		composer.lock		- soubor pro composer
		configuration.ini	- soubor, ve kterém lze něnit nastavení aplikace
		index.php			- vstupní bod aplikace
		LICENSE				- MIT licence projektu
		README.md			- Popis repozitáře na github.com
		database.sql		- Instalační scripty pro MySQL databázi (struktura + data)
		readme.txt			- tento soubor
	