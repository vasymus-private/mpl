<?php

namespace Domain\Ip\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Ip\Models\Ip;
use Support\GeoIp\Exceptions\GeoIpFailedDependencyException;
use Support\GeoIp\Facades\GeoIp;

class GetIpAction extends BaseAction
{
    /**
     * @param string|null $ipAddress
     *
     * @return Ip|null
     */
    public function execute(?string $ipAddress): ?Ip
    {
        if (empty($ipAddress)) {
            return null;
        }

        /** @var \Domain\Ip\Models\Ip $data */
        $data = Ip::query()
            ->where(Ip::TABLE . ".ip", $ipAddress)
            ->first();

        if ($data) {
            return $data;
        }

        try {
            $ipItemDto = GeoIp::getIpInfo($ipAddress);
        } catch (GeoIpFailedDependencyException) {
            return null;
        }

        $ip = new Ip();
        $ip->ip = $ipItemDto->ip;
        $ip->country_a2 = $ipItemDto->country_code3;
        $ip->country_name = $ipItemDto->country_name;
        $ip->country_img = $ipItemDto->country_flag;
        $ip->city = $ipItemDto->city;
        $ip->meta = $ipItemDto->toArray();

        $ip->save();

        return $ip;
    }
}
