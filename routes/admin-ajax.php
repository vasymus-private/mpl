<?php

/*
|--------------------------------------------------------------------------
| Web Routes for admin ajax requests
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * !!!
 * Prefix "admin-ajax"
 * !!!
 * */

use App\Constants;
use Illuminate\Support\Facades\Route;

Route::put('profiles/{admin}', [\App\Http\Controllers\Admin\Ajax\ProfileController::class, 'update'])->name('admin-ajax.profile.update');
Route::post('show-order-busy', \App\Http\Controllers\Admin\Ajax\ShowOrderBusyController::class)->name('admin-ajax.show-order-busy');
Route::post('ping-order-busy/{id}', \App\Http\Controllers\Admin\Ajax\PingOrderBusyController::class)->name('admin-ajax.ping-order-busy');

Route::put('products-bulk', [\App\Http\Controllers\Admin\Ajax\ProductsBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE);
Route::post('product', [\App\Http\Controllers\Admin\Ajax\ProductsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_STORE);
Route::put('product/{admin_product}', [\App\Http\Controllers\Admin\Ajax\ProductsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE);
Route::put('sort-columns', \App\Http\Controllers\Admin\Ajax\SortColumnsController::class)->name(Constants::ROUTE_ADMIN_AJAX_SORT_COLUMNS);

Route::post('helper/slug', [\App\Http\Controllers\Admin\Ajax\HelperController::class, 'slug'])->name(Constants::ROUTE_ADMIN_AJAX_HELPER);

Route::post('product-image-upload/{admin_product}', [\App\Http\Controllers\Admin\Ajax\ProductImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD);

Route::get('product-search', [\App\Http\Controllers\Admin\Ajax\ProductSearchController::class, 'index'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_SEARCH);
