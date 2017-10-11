<?php

// Načtení Autoloaderu
require __DIR__ . '/vendor/autoload.php';

// Použití tříd
use App\Database;
use App\Configuration as C;
use App\Route;

// Připojení k databázi
Database::connect("127.0.0.1", "root", "", "web", 3306);

$r = Route::getInstance();
Route::tryRoute();

?>