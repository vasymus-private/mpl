<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\GalleryItem;
use App\Models\Product\Product;
use App\Models\Service;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapAdminAjaxRoutes();

        $this->mapWebRoutes();

        $this->mapAjaxRoutes();



        $this->routeBinding();

        $routes = [];
        $routeCollection = Route::getRoutes();
        /** @var \Illuminate\Routing\Route $value */
        foreach ($routeCollection as $value) {

            $name = $value->getName();
//            dump("$name : {$value->uri} : " . implode(", ", $value->methods));
            $routes[$name] = [
                'name' => $name,
                'uri' => $value->uri,
                'action-name' => $value->getActionName(),
                'methods' => $value->methods(),
                'matches' => $value->uri(),
            ];
        }
        //dd($routes);
    }

    protected function routeBinding()
    {
        Route::bind("category_slug", [Category::class, "rbCategorySlug"]);
        Route::bind("subcategory1_slug", [Category::class, "rbSubcategory1Slug"]);
        Route::bind("subcategory2_slug", [Category::class, "rbSubcategory2Slug"]);
        Route::bind("subcategory3_slug", [Category::class, "rbSubcategory3Slug"]);

        Route::bind("product_slug", [Product::class, "rbProductSlug"]);

        Route::bind("parentGalleryItemSlug", [GalleryItem::class, "rbParentGalleryItemSlug"]);

        Route::bind("service_slug", [Service::class, "rbServiceSlug"]);

        Route::bind("article_slug", [Article::class, "rbArticleSlug"]);
        Route::bind("subarticle_slug", [Article::class, "rbSubArticleSlug"]);

        Route::bind("brand_slug", [Brand::class, "rbBrandSlug"]);

        Route::bind("faq_slug", [FAQ::class, "rbFaqSlug"]);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::prefix("ajax")
            ->name("ajax.")
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/ajax.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::prefix("admin")
            ->name("admin.")
            //->middleware(['web', "auth:web-admin"])
            //->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    protected function mapAdminAjaxRoutes()
    {
        Route::prefix("admin-ajax")
            ->name("admin-ajax.")
            ->middleware(['web', "auth:web-admin"])
            //->namespace($this->namespace)
            ->group(base_path('routes/admin-ajax.php'));
    }
}
