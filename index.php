<?php

// Chybové hlášky
error_reporting(0);

// Načtení Autoloaderu
require __DIR__ . '/vendor/autoload.php';

// Session
ob_start();
session_start();

// Načtení požadovaných tříd
use App\Main;

// Zapnutí aplikace
Main::start();

?>