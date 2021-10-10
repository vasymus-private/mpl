<?php

namespace Domain\Common\Actions;

use Illuminate\Support\Facades\Cache;

abstract class BaseAction
{
    public static function cached(): self
    {
        return Cache::store('array')->rememberForever(static::class, fn():self => resolve(static::class));
    }
}
