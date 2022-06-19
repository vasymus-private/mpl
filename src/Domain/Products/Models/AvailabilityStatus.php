<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 *
 * @see \Domain\Products\Models\AvailabilityStatus::getFormattedShortNameAttribute()
 * @property-read string $formatted_short_name
 * */
class AvailabilityStatus extends BaseModel
{
    public const TABLE = "availability_statuses";

    public const ID_AVAILABLE_IN_STOCK = 1;
    public const ID_AVAILABLE_NOT_IN_STOCK = 2;
    public const ID_NOT_AVAILABLE = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @return string
     */
    public function getFormattedShortNameAttribute(): string
    {
        switch ($this->id) {
            case static::ID_AVAILABLE_IN_STOCK: {
                return 'Есть';
            }
            case static::ID_AVAILABLE_NOT_IN_STOCK: {
                return 'Заказ';
            }
            case static::ID_NOT_AVAILABLE: {
                return 'Нет';
            }
            default: {
                return '';
            }
        }
    }
}
