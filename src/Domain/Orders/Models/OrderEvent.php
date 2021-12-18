<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property int $order_id
 * @property array $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 */
class OrderEvent extends BaseModel
{
    public const TABLE = 'order_events';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
    ];
}
