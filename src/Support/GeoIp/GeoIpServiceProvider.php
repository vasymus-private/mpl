<?php

namespace Support\GeoIp;

use Illuminate\Support\ServiceProvider;
use Support\GeoIp\Contracts\GeoIpInterface;

class GeoIpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->bind(GeoIpInterface::class, function ($app) {
            $config = $app->make('config')->get('services');

            return new GeoIpService($config['ipGeoLocation'] ?? []);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
