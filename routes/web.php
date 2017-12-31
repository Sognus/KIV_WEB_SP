<?php

// Načtení třídy
use App\Routing\Route;

// Routování pro pěkné URL - metoda POST
Route::post("/register", "App\Controllers\RegisterController@post");
Route::post("/login", "App\Controllers\LoginController@post");

// Routování pro pěkné URL - metoda GET
Route::get("/","App\Controllers\AboutController@show");
Route::get("/login", "App\Controllers\LoginController@show");
Route::get("/register", "App\Controllers\RegisterController@show");
Route::get("/about", "App\Controllers\AboutController@show");


// Routování pro základní URL - metoda POST
Route::post("index.php?page=register", "App\Controllers\RegisterController@post");
Route::post("index.php?page=login", "App\Controllers\LoginController@post");

// Routování pro základní URL - metoda GET
Route::get("index.php","App\Controllers\AboutController@show");
Route::get("index.php?page=login", "App\Controllers\LoginController@show");
Route::get("index.php?page=register", "App\Controllers\RegisterController@show");
Route::get("index.php?page=about", "App\Controllers\AboutController@show");