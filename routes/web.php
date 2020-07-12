<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('---test', [\App\Http\Controllers\TestController::class, 'test']);

Route::middleware(["anonymous-uid", "create-anonymous"])->group(function() {
    Route::get('/', function (\Illuminate\Http\Request $request) {

        $uid = $request->cookie("anonymous_uid");

        return view('welcome', compact("uid"));
    });

    /** @see \Laravel\Ui\AuthRouteMethods::auth() */
    Auth::routes(['register' => false, 'login' => false]);
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get("/orders", [\App\Http\Controllers\OrdersController::class, "show"])->name("orders.show");
});

Route::middleware("anonymous-uid")->group(function() {
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, "login"]);
});

