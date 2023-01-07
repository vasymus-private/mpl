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
use App\Http\Controllers\Admin\Ajax\ArticleImageUploadController;
use App\Http\Controllers\Admin\Ajax\ArticlesBulkController;
use App\Http\Controllers\Admin\Ajax\ArticlesController;
use App\Http\Controllers\Admin\Ajax\BrandImageUploadController;
use App\Http\Controllers\Admin\Ajax\BrandsBulkController;
use App\Http\Controllers\Admin\Ajax\BrandsController;
use App\Http\Controllers\Admin\Ajax\CategoriesBulkController;
use App\Http\Controllers\Admin\Ajax\CategoriesController;
use App\Http\Controllers\Admin\Ajax\CategoryImageUploadController;
use App\Http\Controllers\Admin\Ajax\FaqBulkController;
use App\Http\Controllers\Admin\Ajax\FaqController;
use App\Http\Controllers\Admin\Ajax\FaqImageUploadController;
use App\Http\Controllers\Admin\Ajax\GalleryItemBulkController;
use App\Http\Controllers\Admin\Ajax\GalleryItemsController;
use App\Http\Controllers\Admin\Ajax\HelperController;
use App\Http\Controllers\Admin\Ajax\OrderEventsController;
use App\Http\Controllers\Admin\Ajax\OrdersCancelController;
use App\Http\Controllers\Admin\Ajax\OrdersController;
use App\Http\Controllers\Admin\Ajax\PingOrderBusyController;
use App\Http\Controllers\Admin\Ajax\ProductImageUploadController;
use App\Http\Controllers\Admin\Ajax\ProductsBulkController;
use App\Http\Controllers\Admin\Ajax\ProductsController;
use App\Http\Controllers\Admin\Ajax\ProductSearchController;
use App\Http\Controllers\Admin\Ajax\ProfileController;
use App\Http\Controllers\Admin\Ajax\ShowOrderBusyController;
use App\Http\Controllers\Admin\Ajax\SortColumnsController;
use Illuminate\Support\Facades\Route;

Route::put('profiles/{admin}', [ProfileController::class, 'update'])->name('admin-ajax.profile.update');
Route::post('show-order-busy', ShowOrderBusyController::class)->name('admin-ajax.show-order-busy');
Route::post('ping-order-busy/{id}', PingOrderBusyController::class)->name('admin-ajax.ping-order-busy');

Route::put('products-bulk', [ProductsBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE);
Route::delete('products-bulk', [ProductsBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_BULK_DELETE);

Route::put('categories-bulk', [CategoriesBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_BULK_UPDATE);
Route::delete('categories-bulk', [CategoriesBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_BULK_DELETE);

Route::put('brands-bulk', [BrandsBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_BULK_UPDATE);
Route::delete('brands-bulk', [BrandsBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE);

Route::put('faq-bulk', [FaqBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_BULK_UPDATE);
Route::delete('faq-bulk', [FaqBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_BULK_DELETE);

Route::put('article-bulk', [ArticlesBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_ARTICLE_BULK_UPDATE);
Route::delete('article-bulk', [ArticlesBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_ARTICLE_BULK_DELETE);

Route::put('gallery-items-bulk', [GalleryItemBulkController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_UPDATE);
Route::delete('gallery-items-bulk', [GalleryItemBulkController::class, 'delete'])->name(Constants::ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_DELETE);

Route::post('product', [ProductsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_STORE);
Route::put('product/{admin_product}', [ProductsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE);

Route::post('category', [CategoriesController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_STORE);
Route::put('category/{admin_category}', [CategoriesController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORIES_UPDATE);

Route::post('brand', [BrandsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_STORE);
Route::put('brand/{admin_brand}', [BrandsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_BRANDS_UPDATE);

Route::post('faq', [FaqController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_STORE);
Route::put('faq/{admin_faq}', [FaqController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_UPDATE);

Route::post('article', [ArticlesController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_ARTICLE_STORE);
Route::put('article/{admin_article}', [ArticlesController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_ARTICLE_UPDATE);

Route::post('gallery-items', [GalleryItemsController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_GALLERY_ITEM_STORE);
Route::put('gallery-items/{admin_gallery_item}', [GalleryItemsController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_GALLERY_ITEM_UPDATE);

Route::post('order', [OrdersController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_STORE);
Route::put('order/{admin_order}', [OrdersController::class, 'update'])->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_UPDATE);
Route::put('order-cancel/{admin_order}', OrdersCancelController::class)->name(Constants::ROUTE_ADMIN_AJAX_ORDERS_CANCEL);

Route::get('order/{admin_order}/order-events', [OrderEventsController::class, 'index'])->name(Constants::ROUTE_ADMIN_AJAX_ORDER_EVENTS_INDEX);

Route::put('sort-columns', SortColumnsController::class)->name(Constants::ROUTE_ADMIN_AJAX_SORT_COLUMNS);

Route::post('helper/slug', [HelperController::class, 'slug'])->name(Constants::ROUTE_ADMIN_AJAX_HELPER);

Route::post('product-image-upload/{admin_product}', [ProductImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD);

Route::post('category-image-upload/{admin_category}', [CategoryImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD);

Route::post('brand-image-upload/{admin_brand}', [BrandImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_BRAND_IMAGE_UPLOAD);

Route::post('faq-image-upload/{admin_faq}', [FaqImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_FAQ_IMAGE_UPLOAD);

Route::post('article-image-upload/{admin_article}', [ArticleImageUploadController::class, 'store'])->name(Constants::ROUTE_ADMIN_AJAX_ARTICLE_IMAGE_UPLOAD);

Route::get('product-search', [ProductSearchController::class, 'index'])->name(Constants::ROUTE_ADMIN_AJAX_PRODUCT_SEARCH);
