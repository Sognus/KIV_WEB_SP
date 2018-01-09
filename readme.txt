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
    
Postup instalace:
  1)
    a) 
      Připojte se do databáze, kterou bude využívat aplikace (ideální je například
      PHPMyAdmin). 
    b)
      Připravte si spuštění SQL příkazů. Jako SQL příkazy použijte obsah souboru
      database.sql
  2)
    a)
      Do souboru configuration.ini vyplňte údaje pro připojení k databázi.
    b)
      Zkontrolujte, že aplikace již nyní nehlásí problém s připojením do databáze
      a v sekci index.php?page=content je jeden příspěvek
    c)
      Nyní musíte správně nastavit root projektu v konfiguračním souboru i v .htaccess
      Pokud se projekt nachází na adrese http://students.kiv.zcu.cz/~viteja/kiv-web-sp/
      platí:
        I)
          Configuration.ini:
            APP_ROOT="/~viteja/kiv-web-sp"
        II)  
          .htaccess:
            RewriteBase /~viteja/kiv-web-sp/
      
      Pozor na správně umístěná lomítka
  3)
    a) Přístupové údaje na administrátora (po vytvoření struktury z database.sql):
      přezdívka: Sognus
      heslo: duyz60tip
    
    b) V případě že není možné se na administrátora přihlásit, vytvořte si uživatele
    s vlastním heslem a v tabulce viteja_web_users mu nastavte příznak account
    na hodnotu 2.
  4)
    Aplikace by měla vykreslovat veškerý obsah a být funkční.
   
       