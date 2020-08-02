<?php

namespace App\Providers;

use App\View\Components\MbManufacturersFilter;
use App\View\Components\SeoComponent;
use App\View\Components\SidebarManufacturersFilterComponent;
use App\View\Components\SidebarMenuCart;
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
        Blade::component("sidebar-manufacturers-filter", SidebarManufacturersFilterComponent::class);
        Blade::component("mb-manufacturers-filter", MbManufacturersFilter::class);
        Blade::component("sidebar-menu-cart", SidebarMenuCart::class);
        Blade::component("sidebar-menu-favourites-count", SidebarMenuFavouritesCountComponent::class);
        Blade::component("sidebar-menu-viewed", SidebarMenuViewedComponent::class);
    }
}
