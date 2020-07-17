<?php

namespace App\Models;

/**
 * @property int $id
 * @property int $product_id
 * @property float $price
 * @property string $name
 * */
class InformationalPrice extends BaseModel
{
    const TABLE = "informational_prices";

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
}
