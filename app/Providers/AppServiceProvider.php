<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\FAQ;
use App\Models\Manufacturer;
use App\Models\Product\Product;
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
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'products' => Product::class,
            "manufacturers" => Manufacturer::class,
            "categories" => Category::class,
            "faq" => FAQ::class,
        ]);
    }
}
