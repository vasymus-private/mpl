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
Route::delete('products-bulk', [\App\Http\Controllers\Admin\Ajax\ProductsBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_BULK_DELETE);

Route::put('categories-bulk', [\App\Http\Controllers\Admin\Ajax\CategoriesBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_BULK_UPDATE);
Route::delete('categories-bulk', [\App\Http\Controllers\Admin\Ajax\CategoriesBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_BULK_DELETE);

Route::put('brands-bulk', [\App\Http\Controllers\Admin\Ajax\BrandsBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_BULK_UPDATE);
Route::delete('brands-bulk', [\App\Http\Controllers\Admin\Ajax\BrandsBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE);

Route::put('faq-bulk', [\App\Http\Controllers\Admin\Ajax\FaqBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_BULK_UPDATE);
Route::delete('faq-bulk', [\App\Http\Controllers\Admin\Ajax\FaqBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_BULK_DELETE);

Route::post('product', [\App\Http\Controllers\Admin\Ajax\ProductsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_STORE);
Route::put('product/{admin_product}', [\App\Http\Controllers\Admin\Ajax\ProductsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE);

Route::post('category', [\App\Http\Controllers\Admin\Ajax\CategoriesController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_STORE);
Route::put('category/{admin_category}', [\App\Http\Controllers\Admin\Ajax\CategoriesController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_UPDATE);

Route::post('brand', [\App\Http\Controllers\Admin\Ajax\BrandsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_STORE);
Route::put('brand/{admin_brand}', [\App\Http\Controllers\Admin\Ajax\BrandsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_UPDATE);

Route::post('faq', [\App\Http\Controllers\Admin\Ajax\FaqController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_STORE);
Route::put('faq/{admin_faq}', [\App\Http\Controllers\Admin\Ajax\FaqController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_UPDATE);

Route::post('order', [\App\Http\Controllers\Admin\Ajax\OrdersController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_STORE);
Route::put('order/{admin_order}', [\App\Http\Controllers\Admin\Ajax\OrdersController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_UPDATE);
Route::put('order-cancel/{admin_order}', \App\Http\Controllers\Admin\Ajax\OrdersCancelController::class)->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_CANCEL);

Route::get('order/{admin_order}/order-events', [\App\Http\Controllers\Admin\Ajax\OrderEventsController::class, 'index'])->name(Constants::ROUTE_ADMIN_AJAX_ORDER_EVENTS_INDEX);

Route::put('sort-columns', \App\Http\Controllers\Admin\Ajax\SortColumnsController::class)->name(Constants::ROUTE_ADMIN_AJAX_SORT_COLUMNS);

Route::post('helper/slug', [\App\Http\Controllers\Admin\Ajax\HelperController::class, 'slug'])->name(Constants::ROUTE_ADMIN_AJAX_HELPER);

Route::post('product-image-upload/{admin_product}', [\App\Http\Controllers\Admin\Ajax\ProductImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD);

Route::post('category-image-upload/{admin_category}', [\App\Http\Controllers\Admin\Ajax\CategoryImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD);

Route::post('brand-image-upload/{admin_brand}', [\App\Http\Controllers\Admin\Ajax\BrandImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_BRAND_IMAGE_UPLOAD);

Route::get('product-search', [\App\Http\Controllers\Admin\Ajax\ProductSearchController::class, 'index'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_SEARCH);
