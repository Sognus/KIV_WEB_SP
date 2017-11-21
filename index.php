<?php

// Načtení Autoloaderu
require __DIR__ . '/vendor/autoload.php';

// Použití tříd
use App\Database;
use App\Configuration as Config;
use App\Routing\Route;
use App\Views\View;

// Připojení k databázi
Database::connect("127.0.0.1", "root", "", "web", 3306);
View::setup(Config::get("APP_VIEW"));
Route::tryRoute();

?>