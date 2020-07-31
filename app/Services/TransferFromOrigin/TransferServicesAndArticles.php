<?php

namespace App\Services\TransferFromOrigin;

class TransferServicesAndArticles extends BaseTransfer
{
    public function transfer()
    {
        $raw = require(storage_path("app/seeds/pages/raw.php"));
    }

}
