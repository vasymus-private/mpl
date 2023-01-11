<?php

namespace Support\GeoIp\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class IpItemDTO extends DataTransferObject
{
    /**
     * @var string
     */
    public string $ip;

    /**
     * @var string|null
     */
    public ?string $country_code2;

    /**
     * @var string|null
     */
    public ?string $continent_code;

    /**
     * @var string|null
     */
    public ?string $continent_name;

    /**
     * @var string|null
     */
    public ?string $country_code3;

    /**
     * @var string|null
     */
    public ?string $country_name;

    /**
     * @var string|null
     */
    public ?string $country_capital;

    /**
     * @var string|null
     */
    public ?string $state_prov;

    /**
     * @var string|null
     */
    public ?string $district;

    /**
     * @var string|null
     */
    public ?string $city;

    /**
     * @var string|null
     */
    public ?string $zipcode;

    /**
     * @var string|null
     */
    public ?string $latitude;

    /**
     * @var string|null
     */
    public ?string $longitude;

    /**
     * @var bool|null
     */
    public ?bool $is_eu;

    /**
     * @var string|null
     */
    public ?string $calling_code;

    /**
     * @var string|null
     */
    public ?string $country_tld;

    /**
     * @var string|null
     */
    public ?string $languages;

    /**
     * @var string|null
     */
    public ?string $country_flag;

    /**
     * @var string|null
     */
    public ?string $geoname_id;

    /**
     * @var string|null
     */
    public ?string $isp;

    /**
     * @var string|null
     */
    public ?string $connection_type;

    /**
     * @var string|null
     */
    public ?string $organization;

    /**
     * @var string|null
     */
    public ?string $currency_code;

    /**
     * @var string|null
     */
    public ?string $currency_name;

    /**
     * @var string|null
     */
    public ?string $currency_symbol;

    /**
     * @var string|null
     */
    public ?string $time_zone_name;

    /**
     * @var int|float|null
     */
    public $time_zone_offset;

    /**
     * @var string|null
     */
    public ?string $time_zone_current_time;

    /**
     * @var int|float|null
     */
    public $time_zone_current_time_unix;

    /**
     * @var bool|null
     */
    public ?bool $time_zone_is_dst;

    /**
     * @var int|string|null
     */
    public $time_zone_dst_savings;

    /**
     * @param array $response
     *
     * @return self
     *
     * example response @see https://i.imgur.com/uGMDMR1.png
     * */
    public static function fromResponse(array $response): self
    {
        return new self([
            "ip" => $response["ip"],
            "country_code2" => $response["country_code2"],

            "continent_code" => $response["continent_code"] ?? null,
            "continent_name" => $response["continent_name"] ?? null,
            "country_code3" => $response["country_code3"] ?? null,
            "country_name" => $response["country_name"] ?? null,
            "country_capital" => $response["country_capital"] ?? null,
            "state_prov" => $response["state_prov"] ?? null,
            "district" => $response["district"] ?? null,
            "city" => $response["city"] ?? null,
            "zipcode" => $response["zipcode"] ?? null,
            "latitude" => $response["latitude"] ?? null,
            "longitude" => $response["longitude"] ?? null,
            "is_eu" => $response["is_eu"] ?? null,
            "calling_code" => $response["calling_code"] ?? null,
            "country_tld" => $response["country_tld"] ?? null,
            "languages" => $response["languages"] ?? null,
            "country_flag" => $response["country_flag"] ?? null,
            "geoname_id" => $response["geoname_id"] ?? null,
            "isp" => $response["isp"] ?? null,
            "connection_type" => $response["connection_type"] ?? null,
            "organization" => $response["organization"] ?? null,

            "currency_code" => $response["currency"]["code"] ?? null,
            "currency_name" => $response["currency"]["name"] ?? null,
            "currency_symbol" => $response["currency"]["symbol"] ?? null,

            "time_zone_name" => $response["time_zone"]["name"] ?? null,
            "time_zone_offset" => $response["time_zone"]["offset"] ?? null,
            "time_zone_current_time" => $response["time_zone"]["current_time"] ?? null,
            "time_zone_current_time_unix" => $response["time_zone"]["current_time_unix"] ?? null,
            "time_zone_is_dst" => $response["time_zone"]["is_dst"] ?? null,
            "time_zone_dst_savings" => $response["time_zone"]["dst_savings"] ?? null,
        ]);
    }
}
