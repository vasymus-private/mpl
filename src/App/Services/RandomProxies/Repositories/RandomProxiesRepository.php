<?php

namespace App\Services\RandomProxies\Repositories;

use App\Services\RandomProxies\Contracts\CanGetRandomProxies;
use App\Services\RandomProxies\DTOs\ProxyDTO;

class RandomProxiesRepository implements CanGetRandomProxies
{
    /**
     * @var \App\Services\RandomProxies\DTOs\ProxyDTO[]
     * */
    protected $store;

    /**
     * @param \App\Services\RandomProxies\DTOs\ProxyDTO[] $store
     * */
    public function __construct(array $store = [])
    {
        $this->store = $store;
    }

    /**
     * @return \App\Services\RandomProxies\DTOs\ProxyDTO
     * */
    public function getOneRandomProxy(): ?ProxyDTO
    {
        $all = $this->getAllRandomProxies();
        if (empty($all)) return null;

        return collect($all)->take(20)->random();
    }

    /**
     * @return \App\Services\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function getAllRandomProxies(): array
    {
        return collect($this->store)
            ->sort(function(ProxyDTO $a, ProxyDTO $b) {
                return $b->lastChecked->getTimestamp() - $a->lastChecked->getTimestamp();
            })
            ->values()
            ->toArray()
        ;
    }

}
