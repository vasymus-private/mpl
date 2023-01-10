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

use App\Constants;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ContactFormsController;
use App\Http\Controllers\Admin\ExportProductController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryItemsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\TestInertiaController;
use Illuminate\Support\Facades\Route;

Route::get("home", [HomeController::class, "index"])->name(Constants::ROUTE_ADMIN_HOME);
Route::get("home-temp", [HomeController::class, "indexTemp"])->name(Constants::ROUTE_ADMIN_TEMP_HOME);
Route::get("media/{id}/{name?}", [HomeController::class, "media"])->name(Constants::ROUTE_ADMIN_MEDIA);

Route
    ::get(
        "products",
        [ProductsController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_INDEX)
;
Route
    ::get(
        "temp-products",
        [ProductsController::class, "indexTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_TEMP_INDEX)
;
Route
    ::get(
        "products/create",
        [ProductsController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_CREATE)
;
Route
    ::get(
        "temp-products/create",
        [ProductsController::class, "createTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_TEMP_CREATE)
;
Route
    ::get(
        "products/{admin_product}/edit",
        [ProductsController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_EDIT)
;
Route
    ::get(
        "temp-products/{admin_product}/edit",
        [ProductsController::class, "editTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_PRODUCTS_TEMP_EDIT)
;

Route
    ::get(
        "categories",
        [CategoriesController::class, 'index']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_INDEX)
;
Route
    ::get(
        "temp-categories",
        [CategoriesController::class, 'indexTemp']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_TEMP_INDEX)
;
Route
    ::get(
        "categories/create",
        [CategoriesController::class, 'create']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_CREATE)
;
Route
    ::get(
        "temp-categories/create",
        [CategoriesController::class, 'createTemp']
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_TEMP_CREATE)
;
Route
    ::get(
        "categories/{admin_category}/edit",
        [CategoriesController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_EDIT)
;
Route
    ::get(
        "temp-categories/{admin_category}/edit",
        [CategoriesController::class, "editTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_CATEGORIES_TEMP_EDIT)
;

Route
    ::get(
        "brands",
        [BrandsController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_INDEX)
;
Route
    ::get(
        "brands/create",
        [BrandsController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_CREATE)
;
Route
    ::get(
        "brands/{admin_brand}/edit",
        [BrandsController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_EDIT)
;

Route
    ::get(
        "temp-brands",
        [BrandsController::class, "indexTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_TEMP_INDEX)
;
Route
    ::get(
        "temp-brands/create",
        [BrandsController::class, "createTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_TEMP_CREATE)
;
Route
    ::get(
        "temp-brands/{admin_brand}/edit",
        [BrandsController::class, "editTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_BRANDS_TEMP_EDIT)
;

Route
    ::get(
        "orders",
        [OrdersController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_INDEX)
;
Route
    ::get(
        "orders/create",
        [OrdersController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_CREATE)
;
Route
    ::get(
        "orders/{admin_order}/edit",
        [OrdersController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_EDIT)
;

Route
    ::get(
        "orders-temp",
        [OrdersController::class, "indexTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_TEMP_INDEX)
;
Route
    ::get(
        "orders-temp/create",
        [OrdersController::class, "createTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_TEMP_CREATE)
;
Route
    ::get(
        "orders-temp/{admin_order}/edit",
        [OrdersController::class, "editTemp"]
    )
    ->name(Constants::ROUTE_ADMIN_ORDERS_TEMP_EDIT)
;

Route
    ::get(
        "faqs",
        [FaqController::class, "index"]
    )
    ->name(Constants::ROUTE_ADMIN_FAQ_INDEX)
;
Route
    ::get(
        "faqs/create",
        [FaqController::class, "create"]
    )
    ->name(Constants::ROUTE_ADMIN_FAQ_CREATE)
;
Route
    ::get(
        "faqs/{admin_faq}/edit",
        [FaqController::class, "edit"]
    )
    ->name(Constants::ROUTE_ADMIN_FAQ_EDIT)
;

Route::
    get(
        'export-products',
        [ExportProductController::class, 'index']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)
;
Route::
    get(
        'export-products/{id}',
        [ExportProductController::class, 'show']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW)
;
Route::
    post(
        'export-products',
        [ExportProductController::class, 'store']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_STORE)
;
Route::
    delete(
        'export-products/{id}',
        [ExportProductController::class, 'delete']
    )
    ->name(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE)
;

Route::
    get(
        'articles',
        [ArticlesController::class, 'index']
    )
    ->name(Constants::ROUTE_ADMIN_ARTICLES_INDEX)
;
Route::
get(
    'articles/create',
    [ArticlesController::class, 'create']
)
    ->name(Constants::ROUTE_ADMIN_ARTICLES_CREATE)
;
Route::
get(
    'articles/{admin_article}/edit',
    [ArticlesController::class, 'edit']
)
    ->name(Constants::ROUTE_ADMIN_ARTICLES_EDIT)
;

Route::
get(
    'gallery-items',
    [GalleryItemsController::class, 'index']
)
    ->name(Constants::ROUTE_ADMIN_GALLERY_ITEMS_INDEX)
;
Route::
get(
    'gallery-items/create',
    [GalleryItemsController::class, 'create']
)
    ->name(Constants::ROUTE_ADMIN_GALLERY_ITEMS_CREATE)
;
Route::
get(
    'gallery-items/{admin_gallery_item}/edit',
    [GalleryItemsController::class, 'edit']
)
    ->name(Constants::ROUTE_ADMIN_GALLERY_ITEMS_EDIT)
;

Route::
get(
    'contact-forms',
    [ContactFormsController::class, 'index']
)
    ->name(Constants::ROUTE_ADMIN_CONTACT_FORMS_INDEX)
;
Route::
get(
    'contact-forms/{admin_contact_form}/show',
    [ContactFormsController::class, 'show']
)
    ->name(Constants::ROUTE_ADMIN_CONTACT_FORMS_SHOW)
;

Route::
get(
    'blacklist',
    [BlacklistController::class, 'index']
)
    ->name(Constants::ROUTE_ADMIN_BLACKLIST_INDEX)
;
Route::
get(
    'blacklist/create',
    [BlacklistController::class, 'create']
)
    ->name(Constants::ROUTE_ADMIN_BLACKLIST_CREATE)
;
Route::
get(
    'blacklist/{admin_blacklist}/edit',
    [BlacklistController::class, 'edit']
)
    ->name(Constants::ROUTE_ADMIN_BLACKLIST_EDIT)
;

Route::get('---test-inertia', [TestInertiaController::class, 'index'])->name('admin.test.inertia');
