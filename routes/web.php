<?php

// Načtení třídy
use App\Routing\Route;

// Routování pro pěkné URL
Route::get("/","App\Controllers\TestController@target");


// Routování pro základní URL
Route::get("index.php?page=home&username={userID}", "App\Controllers\TestController@target", array("string", "int"));