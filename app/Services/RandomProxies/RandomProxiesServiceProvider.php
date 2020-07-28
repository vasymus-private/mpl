<?php

namespace App\Services\RandomProxies;

use App\Services\RandomProxies\Contracts\CanGetRandomProxies;
use App\Services\RandomProxies\Contracts\CanFetchRandomProxiesHtml;
use App\Services\RandomProxies\Contracts\CanParseRandomProxiesHtml;
use App\Services\RandomProxies\Repositories\RandomProxiesCacheRepository;
use App\Services\RandomProxies\Repositories\RandomProxiesRepository;
use Illuminate\Support\ServiceProvider;

class RandomProxiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CanFetchRandomProxiesHtml::class, RandomProxiesHtmlFetcher::class);

        $this->app->bind(CanParseRandomProxiesHtml::class, function() {
            /** @var CanFetchRandomProxiesHtml | RandomProxiesHtmlFetcher $fetcher */
            $fetcher = resolve(CanFetchRandomProxiesHtml::class);
            return new RandomProxiesParser(
                $fetcher->fetchRandomProxiesHtml()
            );
        });

        $this->app->bind(CanGetRandomProxies::class, function() {
            /** @var CanParseRandomProxiesHtml | RandomProxiesParser $parser*/
            $parser = resolve(CanParseRandomProxiesHtml::class);

            $repo = new RandomProxiesRepository($parser->parseRandomProxies());
            return new RandomProxiesCacheRepository(
                $repo
            );
        });
    }
}
