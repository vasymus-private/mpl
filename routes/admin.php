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

Route::get("home", [\App\Http\Controllers\Admin\HomeController::class, "index"])->name("home");

Route
    ::get(
        "products",
        [\App\Http\Controllers\Admin\ProductsController::class, "index"]
    )
    ->name("products.index")
;
Route
    ::get(
        "products/create",
        [\App\Http\Controllers\Admin\ProductsController::class, "create"]
    )
    ->name("products.create")
;
Route
    ::post(
        "products",
        [\App\Http\Controllers\Admin\ProductsController::class, "store"]
    )
    ->name("products.store")
;
Route
    ::get(
        "products/{admin_product}/edit",
        [\App\Http\Controllers\Admin\ProductsController::class, "edit"]
    )
    ->name("products.edit")
;
Route
    ::put(
        "products/{admin_product}",
        [\App\Http\Controllers\Admin\ProductsController::class, "update"]
    )
    ->name("products.update")
;
Route
    ::delete(
        "products/{admin_product}",
        [\App\Http\Controllers\Admin\ProductsController::class, "destroy"]
    )
    ->name("products.destroy")
;
