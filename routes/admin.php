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
    ::get(
        "products/{admin_product}/edit",
        [\App\Http\Controllers\Admin\ProductsController::class, "edit"]
    )
    ->name("products.edit")
;

Route
    ::get(
        "categories",
        [\App\Http\Controllers\Admin\CategoriesController::class, 'index']
    )
    ->name('categories.index')
;
Route
    ::get(
        "categories/create",
        [\App\Http\Controllers\Admin\CategoriesController::class, 'create']
    )
    ->name('categories.create')
;
Route
    ::get(
        "categories/{admin_category}/edit",
        [\App\Http\Controllers\Admin\CategoriesController::class, "edit"]
    )
    ->name("categories.edit")
;

Route
    ::get(
        "brands",
        [\App\Http\Controllers\Admin\BrandsController::class, "index"]
    )
    ->name("brands.index")
;
Route
    ::get(
        "brands/create",
        [\App\Http\Controllers\Admin\BrandsController::class, "create"]
    )
    ->name("brands.create")
;
Route
    ::get(
        "brands/{admin_brand}/edit",
        [\App\Http\Controllers\Admin\BrandsController::class, "edit"]
    )
    ->name("brands.edit")
;
