<?php

namespace App\Services\Common;

use Ramsey\Uuid\Uuid;

class Common
{
    public static function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
