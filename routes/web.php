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


//Route::middleware(["anonymous-uid", "create-anonymous"])->group(function() {



    Route::get("catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{subcategory3_slug?}", [\App\Http\Controllers\Web\ProductsController::class, "index"])->name("products.index");

    Route::get("catalog/{category_slug?}/{subcategory1_slug?}/{product_slug?}.html", [\App\Http\Controllers\Web\ProductsController::class, "show"])->name("products.show1");
    Route::get("catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{product_slug?}.html", [\App\Http\Controllers\Web\ProductsController::class, "show"])->name("products.show2");
    Route::get("catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{subcategory3_slug?}/{product_slug?}.html", [\App\Http\Controllers\Web\ProductsController::class, "show"])->name("products.show3");

    Route::get("brands", [\App\Http\Controllers\Web\BrandsController::class, "index"])->name("brands.index");
    Route::get("brands/{brand_slug}.html", [\App\Http\Controllers\Web\BrandsController::class, "show"])->name("brands.show");

    Route::get("photos", [\App\Http\Controllers\Web\GalleryItemsController::class, "index"])->name("gallery.items.index");
    Route::get("photos/{parentGalleryItemSlug}", [\App\Http\Controllers\Web\GalleryItemsController::class, "show"])->name("gallery.items.show");

    Route::get("articles/{article_slug}/{subarticle_slug?}", [\App\Http\Controllers\Web\ArticlesController::class, "show"])->name("articles.show");

    Route::get("faq", [\App\Http\Controllers\Web\FaqController::class, "index"])->name("faq.index");
    Route::get("faq/{slug}", [\App\Http\Controllers\Web\FaqController::class, "show"])->name("faq.show");

    Route::get("ask", [\App\Http\Controllers\Web\HomeController::class, "ask"])->name("ask");

    Route::get("videos", [\App\Http\Controllers\Web\VideosController::class, "index"])->name("videos.index");

    Route::get("howto", [\App\Http\Controllers\Web\HomeController::class, "howto"])->name("howto");

    Route::get("delivery", [\App\Http\Controllers\Web\HomeController::class, "delivery"])->name("delivery");

    Route::get("return", [\App\Http\Controllers\Web\HomeController::class, "purchaseReturn"])->name("return");

    Route::get("contacts", [\App\Http\Controllers\Web\HomeController::class, "contacts"])->name("contacts");

    Route::get("viewed", [\App\Http\Controllers\Web\HomeController::class, "viewed"])->name("viewed");

    Route::get("deferred", [\App\Http\Controllers\Web\HomeController::class, "deferred"])->name("deferred");

    Route::get('cart', [\App\Http\Controllers\Web\CartController::class, "show"])->name("cart.show");

    Route::get("/{service_slug}", [\App\Http\Controllers\Web\ServicesController::class, "show"])->name("services.show");

    Route::get("/", [\App\Http\Controllers\Web\HomeController::class, "index"])->name("home");

//});




//Route::middleware(["anonymous-uid", "create-anonymous"])->group(function() {
//    Route::get('/', function (\Illuminate\Http\Request $request) {
//
//        $uid = $request->cookie("anonymous_uid");
//
//        return view('welcome', compact("uid"));
//    });
//
//    Route::namespace("App\Http\Controllers\Web")->group(function() {
//        /** @see \Laravel\Ui\AuthRouteMethods::auth() */
//        Auth::routes(['register' => false, 'login' => false]);
//        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//
//        Route::get('/home', 'HomeController@index')->name('home');
//
//        Route::get("/orders", [\App\Http\Controllers\Web\OrdersController::class, "show"])->name("orders.show");
//    });
//});
//
//Route::middleware("anonymous-uid")->group(function() {
//    Route::post('login', [\App\Http\Controllers\Web\Auth\LoginController::class, "login"]);
//});

