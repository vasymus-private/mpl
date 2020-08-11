<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\GalleryItem;
use App\Models\Brand;
use App\Models\Product\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->isProduction()) {
            $this->app->register(\KitLoong\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            "admin" => Admin::class,
            "products" => Product::class,
            "manufacturers" => Brand::class,
            "categories" => Category::class,
            "faq" => FAQ::class,
            "gallery_items" => GalleryItem::class,
            "articles" => Article::class,
            "services" => Service::class,
        ]);
    }
}
