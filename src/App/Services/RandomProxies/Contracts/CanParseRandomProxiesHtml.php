<?php

namespace App\Services\RandomProxies\Contracts;

use App\Services\RandomProxies\DTOs\ProxyDTO;

interface CanParseRandomProxiesHtml
{
    /**
     * Return array of random proxies
     * @return \App\Services\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function parseRandomProxies() : array;
}
