<?php

namespace Support\RandomProxies\Contracts;

use Support\RandomProxies\DTOs\ProxyDTO;

interface CanParseRandomProxiesHtml
{
    /**
     * Return array of random proxies
     * @return \Support\RandomProxies\DTOs\ProxyDTO[]
     * */
    public function parseRandomProxies() : array;
}
