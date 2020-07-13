<?php

namespace App\Services\TransferFromOrigin;

abstract class BaseTransfer
{
    use HasTransfer;
    use HasHtmlParsing;

    public function __construct(string $site = "http://union.parket-lux.ru")
    {
        $this->site = $site;
    }
}
