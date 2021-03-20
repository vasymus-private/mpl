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
    ->name("admin.products.index")
;
Route
    ::get(
        "products/create",
        [\App\Http\Controllers\Admin\ProductsController::class, "create"]
    )
    ->name("admin.products.create")
;
Route
    ::post(
        "products",
        [\App\Http\Controllers\Admin\ProductsController::class, "store"]
    )
    ->name("admin.products.store")
;
Route
    ::get(
        "products/{product_slug}",
        [\App\Http\Controllers\Admin\ProductsController::class, "show"]
    )
    ->name("admin.products.show")
;
Route
    ::get(
        "products/{product_slug}/edit",
        [\App\Http\Controllers\Admin\ProductsController::class, "edit"]
    )
    ->name("admin.products.edit")
;
Route
    ::put(
        "products/{product_slug}",
        [\App\Http\Controllers\Admin\ProductsController::class, "update"]
    )
    ->name("admin.products.update")
;
Route
    ::delete(
        "products/{product_slug}",
        [\App\Http\Controllers\Admin\ProductsController::class, "destroy"]
    )
    ->name("admin.products.destroy")
;
