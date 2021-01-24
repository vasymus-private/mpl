<?php

namespace Domain\Common\Models;

use Domain\Common\Models\BaseModel;

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

    public static function getFormattedName(int $id = null): ?string
    {
        switch ($id) {
            case static::ID_RUB : {
                return "р";
                break;
            }
            case static::ID_EUR : {
                return "EUR";
                break;
            }
            case static::ID_USD : {
                return "USD";
                break;
            }
            default : {
                return null;
                break;
            }
        }
    }

    public static function getIsoName(int $id = null): ?string
    {
        switch ($id) {
            case static::ID_RUB : {
                return "RUB";
                break;
            }
            case static::ID_EUR : {
                return "EUR";
                break;
            }
            case static::ID_USD : {
                return "USD";
                break;
            }
            default : {
                return null;
                break;
            }
        }
    }

    public static function getFormattedValue($value, int $currencyId): string
    {
        if ($currencyId === static::ID_RUB) return number_format(round($value, 0), 0, ",", " ");

        return number_format(round($value, 2), 2, ",", " ");
    }
}
