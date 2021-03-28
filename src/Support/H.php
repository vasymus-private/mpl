<?php

namespace Support;

use App\Constants;
use App\Exception;
use Domain\Common\Models\Currency;
use Support\CBRcurrencyConverter\CBRcurrencyConverter;
use Illuminate\Support\HtmlString;

class H
{
    public static function priceRub(float $value = null, int $currencyId): ?float
    {
        $currencyIso = Currency::getIsoName($currencyId);
        if (!$currencyIso) return null;

        if (!$value) return null;

        return floor(CBRcurrencyConverter::convertRub($currencyIso, $value));
    }

    public static function priceRubFormatted(float $value = null, int $currencyId): string
    {
        $rub = static::priceRub($value, $currencyId);
        if ($rub === null) return "";

        return Currency::getFormattedValue($rub, Currency::ID_RUB) . " " . Currency::getFormattedName(Currency::ID_RUB);
    }

    public static function getPhone1(): HtmlString
    {
        return new HtmlString('<a href="tel:+74953638799">+7 (495) 363 87 99</a>');
    }

    public static function getPhone2(): HtmlString
    {
        return new HtmlString('<a href="tel:+74953638799">+7 (915) 363 93 63</a>');
    }

    public static function getMail(): HtmlString
    {
        return new HtmlString('<a href="mailto:parket-lux@mail.ru">parket-lux@mail.ru</a>');
    }

    public static function website(): string
    {
        return "parket-lux.ru";
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     *
     * @throws \Exception
     * @see https://stackoverflow.com/a/31284266/12540255
     */
    public static function random_str(
        int $length,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    /**
     * @param mixed|string $value
     *
     * @return mixed|string|null
     */
    public static function trimAndNullEmptyString($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    public static function getMimeTypeName($mimeType): string
    {
        switch ($mimeType) {
            case Constants::MIME_DOC :
            case Constants::MIME_DOCX : {
                return "MS Word";
            }
            case Constants::MIME_PPT :
            case Constants::MIME_PPTX : {
                return "MS PowerPoint";
            }
            case Constants::MIME_XLS :
            case Constants::MIME_XLSX : {
                return "MS Excel";
            }
            case Constants::MIME_GIF : {
                return "gif";
            }
            case Constants::MIME_JPEG : {
                return "jpeg";
            }
            case Constants::MIME_PNG : {
                return "png";
            }
            case Constants::MIME_HTML : {
                return "html";
            }
            case Constants::MIME_PDF : {
                return "pdf";
            }
            default : {
                return "";
            }
        }
    }
}
