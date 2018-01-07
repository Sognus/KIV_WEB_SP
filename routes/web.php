<?php

// Načtení třídy
use App\Routing\Route;

// Routování pro pěkné URL - metoda POST
Route::post("/register", "App\Controllers\RegisterController@post");
Route::post("/login", "App\Controllers\LoginController@post");
Route::post("/logout", "App\Controllers\LogoutController@logout");
Route::post("/admin/{part}", "App\Controllers\AdminController@postUsers", array("string"));
Route::post("/admin", "App\Controllers\AdminController@post");
Route::post("/create", "App\Controllers\PostCreateController@post");
Route::post("/user", "App\Controllers\UserController@post");
Route::post("/user/{part}", "App\Controllers\UserController@post", array("string"));
Route::post("/user/edit/{id}", "App\Controllers\UserController@editPost", array("string"));

// Routování pro pěkné URL - metoda GET
Route::get("/","App\Controllers\AboutController@show");
Route::get("/login", "App\Controllers\LoginController@show");
Route::get("/register", "App\Controllers\RegisterController@show");
Route::get("/about", "App\Controllers\AboutController@show");
Route::get("/logout", "App\Controllers\LogoutController@logout");
Route::get("/content", "App\Controllers\ContentController@show");
Route::get("/post/{id}", "App\Controllers\PostController@show", array("int"));
Route::get("/admin/{part}", "App\Controllers\AdminController@show", array("string"));
Route::get("/admin", "App\Controllers\AdminController@show");
Route::get("/create", "App\Controllers\PostCreateController@show");
Route::get("/user", "App\Controllers\UserController@show");
Route::get("/user/{part}", "App\Controllers\UserController@show", array("string"));
Route::get("/user/edit/{id}", "App\Controllers\UserController@editShow", array("string"));

// Routování pro základní URL - metoda POST
Route::post("index.php?page=register", "App\Controllers\RegisterController@post");
Route::post("index.php?page=login", "App\Controllers\LoginController@post");
Route::post("index.php?page=logout", "App\Controllers\LogoutController@logout");
Route::post("index.php?page=admin&part={part}", "App\Controllers\AdminController@post", array("string", "string"));
Route::post("index.php?page=admin", "App\Controllers\AdminController@post", array("string"));
Route::post("index.php?page=create", "App\Controllers\PostCreateController@post");
Route::post("index.php?page=user&part=edit&post={id}", "App\Controllers\UserController@editPost", array("string", "string", "int"));
Route::post("index.php?page=user", "App\Controllers\UserController@post");
Route::post("index.php?page=user&part={part}", "App\Controllers\UserController@post", array("string", "string"));

// Routování pro základní URL - metoda GET
Route::get("index.php","App\Controllers\AboutController@show");
Route::get("index.php?page=login", "App\Controllers\LoginController@show");
Route::get("index.php?page=register", "App\Controllers\RegisterController@show");
Route::get("index.php?page=about", "App\Controllers\AboutController@show");
Route::get("index.php?page=logout", "App\Controllers\LogoutController@logout");
Route::get("index.php?page=content", "App\Controllers\ContentController@show");
Route::get("index.php?page=content&part={part}", "App\Controllers\ContentController@show", array("string","int"));
Route::get("index.php?page=post&id={id}", "App\Controllers\PostController@show", array("int","string"));
Route::get("index.php?page=admin&part={part}", "App\Controllers\AdminController@show", array("string", "string"));
Route::get("index.php?page=admin", "App\Controllers\AdminController@show", array("string"));
Route::get("index.php?page=create", "App\Controllers\PostCreateController@show");
Route::get("index.php?page=user&part=edit&post={id}", "App\Controllers\UserController@editShow", array("string", "string", "int"));
Route::get("index.php?page=user", "App\Controllers\UserController@show");
Route::get("index.php?page=user&part={part}", "App\Controllers\UserController@show", array("string", "string"));
