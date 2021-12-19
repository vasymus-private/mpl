<?php

namespace Domain\Orders\Enums;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Spatie\Enum\Enum;

/**
 * @method static self checkout()
 * @method static self admin_created()
 */
class OrderEventType extends Enum
{
    /**
     * @return string[]|int[]|Closure
     * @psalm-return array<string, string|int> | Closure(string):(int|string)
     */
    protected static function values()
    {
        return [
            'checkout' => 1,
            'admin_created' => 2,
        ];
    }
}
