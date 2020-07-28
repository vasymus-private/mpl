<?php

namespace App\Services\Traits;

use App\Contracts\RandomProxies\CanGetRandomProxies;
use App\Repositories\RandomProxies\RandomProxiesCacheRepository;
use App\Repositories\RandomProxies\RandomProxiesRepository;
use Campo\UserAgent;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;

trait CanFetchHtml
{
    /**
     * @var Builder
     * */
    protected $fetchBuilder;

    protected function prepareFetch(string $url): self
    {
        $this->fetchBuilder = Curl::to($url);
        return $this;
    }

    protected function addUserAgent(): self
    {
        $headers = [];
        try {
            $headers[] = "User-Agent: " . UserAgent::random();
        } catch (\Exception $exc) {}

        if (!empty($headers)) $this->fetchBuilder->withHeaders($headers);

        return $this;
    }

    protected function addRandomProxy(): self
    {
        /** @var CanGetRandomProxies | RandomProxiesCacheRepository | RandomProxiesRepository $proxies */
        $proxies = resolve(CanGetRandomProxies::class);
        $randomProxy = $proxies->getOneRandomProxy();
        if ($randomProxy) $this->fetchBuilder->withProxy($randomProxy->ip, $randomProxy->port);
        return $this;
    }

    protected function execFetch(): string
    {
        $content = $this->fetchBuilder->get();
        if (!$content || gettype($content) !== "string") $content = "";

        return $content;
    }
}
