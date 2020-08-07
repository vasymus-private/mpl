<?php

namespace App;

use App\Models\Currency;
use App\Services\CBRcurrencyConverter\CBRcurrencyConverter;

class H
{
    public static function priceRub(float $value = null, int $currencyId): ?float
    {
        $currencyIso = Currency::getIsoName($currencyId);
        if (!$currencyIso) return null;

        if (!$value) return null;

        return CBRcurrencyConverter::convertRub($currencyIso, $value);
    }

    public static function priceRubFormatted(float $value = null, int $currencyId): string
    {
        $rub = static::priceRub($value, $currencyId);
        if ($rub === null) return "";

        return Currency::getFormattedValue($rub, Currency::ID_RUB) . " " . Currency::getFormattedName(Currency::ID_RUB);
    }
}
