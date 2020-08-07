<?php

namespace App\Providers;

use App\View\Components\BreadcrumbsComponent;
use App\View\Components\MbBrandsFilterComponent;
use App\View\Components\MbMenuMaterialsComponent;
use App\View\Components\ProductItemComponent;
use App\View\Components\SeoComponent;
use App\View\Components\SidebarBrandsFilterComponent;
use App\View\Components\SidebarMenuCartComponent;
use App\View\Components\SidebarMenuFavouritesCountComponent;
use App\View\Components\SidebarMenuMaterialsComponent;
use App\View\Components\SidebarMenuServicesComponent;
use App\View\Components\SidebarMenuViewedComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component("seo", SeoComponent::class);
        Blade::component("sidebar-menu-materials", SidebarMenuMaterialsComponent::class);
        Blade::component("sidebar-menu-services", SidebarMenuServicesComponent::class);
        Blade::component("sidebar-brands-filter", SidebarBrandsFilterComponent::class);
        Blade::component("mb-brands-filter", MbBrandsFilterComponent::class);
        Blade::component("mb-menu-materials", MbMenuMaterialsComponent::class);
        Blade::component("sidebar-menu-cart", SidebarMenuCartComponent::class);
        Blade::component("sidebar-menu-favourites-count", SidebarMenuFavouritesCountComponent::class);
        Blade::component("sidebar-menu-viewed", SidebarMenuViewedComponent::class);

        Blade::component("product-item", ProductItemComponent::class);

        Blade::component("breadcrumbs", BreadcrumbsComponent::class);
    }
}
