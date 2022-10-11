<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property int $product_id
 * @property float $price
 * @property string $name
 * */
class InformationalPrice extends BaseModel
{
    public const TABLE = "informational_prices";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        $cb = function (self $model) {
            if (! $model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        };

        static::saving($cb);
    }
}
