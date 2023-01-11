<?php

namespace Support\GeoIp\Facades;

use Illuminate\Support\Facades\Facade;
use Support\GeoIp\Contracts\GeoIpInterface;

/**
 * @method static \Support\GeoIp\DTOs\IpItemDTO getIpInfo(string $ip)
 *
 * @see \Support\GeoIp\GeoIpService
 * */
class GeoIp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return GeoIpInterface::class;
    }
}
