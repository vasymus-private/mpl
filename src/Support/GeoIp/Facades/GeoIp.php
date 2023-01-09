<?php

namespace Support\GeoIp\Facades;

use Illuminate\Support\Facades\Facade;
use Support\GeoIp\Contracts\GeoIpInterface;
use Support\GeoIp\DTOs\IpItemDTO;
use Support\GeoIp\GeoIpService;

/**
 * @method static IpItemDTO getIpInfo(string $ip)
 *
 * @see GeoIpService
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
