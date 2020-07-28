<?php

namespace App\Services\RandomProxies\Contracts;

use App\Services\RandomProxies\DTOs\ProxyDTO;

interface CanGetRandomProxies
{
    /**
     * @return App\Services\RandomProxies\DTOs\ProxyDTO
     * */
    public function getOneRandomProxy(): ?ProxyDTO;

    /**
     * @return App\Services\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function getAllRandomProxies(): array;

}
