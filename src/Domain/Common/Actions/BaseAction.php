<?php

namespace Domain\Common\Actions;

use Support\H;

abstract class BaseAction
{
    /**
     * @return static
     */
    public static function cached(): static
    {
        return H::runtimeCache(static::class, fn () => resolve(static::class));
    }
}
