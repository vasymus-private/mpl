<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Admin
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * !!!
 * Prefix "admin"
 * Name "admin."
 * !!!
 * */

use Illuminate\Support\Facades\Route;

/** @see \Laravel\Ui\AuthRouteMethods::auth() */
Route::get('login', [\App\Http\Controllers\Web\Auth\LoginController::class, "showLoginForm"])->name('login')->withoutMiddleware("auth:web-admin");
Route::post('login', [\App\Http\Controllers\Web\Auth\LoginController::class, "login"])->withoutMiddleware("auth:web-admin");


Route::get("home", [\App\Http\Controllers\Admin\HomeController::class, "index"])->name("home");
