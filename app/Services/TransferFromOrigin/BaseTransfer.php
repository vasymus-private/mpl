<?php

namespace App\Services\TransferFromOrigin;

abstract class BaseTransfer
{
    use HasTransfer;

    public function __construct(string $site = "http://union.parket-lux.ru")
    {
        $this->site = $site;
    }
}
