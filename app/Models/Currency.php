<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $name
 * */
class Currency extends BaseModel
{
    const TABLE = "currencies";

    const ID_RUB = 1;
    const ID_EUR = 2;
    const ID_USD = 3;

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
