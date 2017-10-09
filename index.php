<?php

// Načtení Autoloaderu
require __DIR__ . '/vendor/autoload.php';

// Použití tříd
use App\Database;
use App\Configuration as C;

// Připojení k databázi
Database::connect("127.0.0.1", "root", "", "web", 3306);

echo C::get("APP_NaME");

?>