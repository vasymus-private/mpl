<?php

namespace Support\GeoIp\Contracts;

use Support\GeoIp\DTOs\IpItemDTO;

interface GeoIpInterface
{
    /**
     * @param string $ip
     *
     * @return IpItemDTO
     */
    public function getIpInfo(string $ip): IpItemDTO;

}
