<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;
use Domain\Orders\Enums\OrderEventType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @see {@link \Domain\Orders\Models\OrderEvent::getTypeAttribute()} {@link \Domain\Orders\Models\OrderEvent::setTypeAttribute()}
 * @property \Domain\Orders\Enums\OrderEventType $type DB column is {@link int}
 * @property array $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 *
 * @see \Domain\Orders\Models\OrderEvent::order()
 * @property \Domain\Orders\Models\Order $order
 */
class OrderEvent extends BaseModel
{
    public const TABLE = 'order_events';

    public const UPDATED_AT = null;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * @return \Domain\Orders\Enums\OrderEventType
     */
    public function getTypeAttribute(): OrderEventType
    {
        return OrderEventType::from($this->attributes['type']);
    }

    public function setTypeAttribute(OrderEventType $orderEventType)
    {
        $this->attributes['type'] = $orderEventType->value;
    }
}
