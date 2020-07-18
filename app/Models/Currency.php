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

    public static function getIdByName(string $name): ?int
    {
        switch (strtolower($name)) {
            case "rub" : {
                return static::ID_RUB;
                break;
            }
            case "eur" : {
                return static::ID_EUR;
                break;
            }
            case "usd" : {
                return static::ID_USD;
                break;
            }
            default : {
                return null;
                break;
            }
        }
    }
}
