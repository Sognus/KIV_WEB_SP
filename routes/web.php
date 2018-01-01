<?php

// Načtení třídy
use App\Routing\Route;

// Routování pro pěkné URL - metoda POST
Route::post("/register", "App\Controllers\RegisterController@post");
Route::post("/login", "App\Controllers\LoginController@post");
Route::post("/logout", "App\Controllers\LogoutController@logout");

// Routování pro pěkné URL - metoda GET
Route::get("/","App\Controllers\AboutController@show");
Route::get("/login", "App\Controllers\LoginController@show");
Route::get("/register", "App\Controllers\RegisterController@show");
Route::get("/about", "App\Controllers\AboutController@show");
Route::get("/logout", "App\Controllers\LogoutController@logout");
Route::get("/content", "App\Controllers\ContentController@show");
Route::get("/post/{id}", "App\Controllers\PostController@show", array("int"));


// Routování pro základní URL - metoda POST
Route::post("index.php?page=register", "App\Controllers\RegisterController@post");
Route::post("index.php?page=login", "App\Controllers\LoginController@post");
Route::post("index.php?page=logout", "App\Controllers\LogoutController@logout");

// Routování pro základní URL - metoda GET
Route::get("index.php","App\Controllers\AboutController@show");
Route::get("index.php?page=login", "App\Controllers\LoginController@show");
Route::get("index.php?page=register", "App\Controllers\RegisterController@show");
Route::get("index.php?page=about", "App\Controllers\AboutController@show");
Route::get("index.php?page=logout", "App\Controllers\LogoutController@logout");
Route::get("index.php?page=content", "App\Controllers\ContentController@show");
Route::get("index.php?page=content&part={part}", "App\Controllers\ContentController@show", array("string","int"));
Route::get("index.php?page=post&id={id}", "App\Controllers\PostController@show", array("int","string"));