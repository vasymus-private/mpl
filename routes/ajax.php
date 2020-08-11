<?php

/*
|--------------------------------------------------------------------------
| Web Routes for ajax requests
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * !!!
 * Prefix "ajax"
 * Name "ajax."
 * !!!
 * */

use Illuminate\Support\Facades\Route;

Route::middleware(["auth"])->group(function() {
    Route::post("products/aside", [\App\Http\Controllers\Web\Ajax\AsideProductsController::class, "store"])->name("products.aside");
});
