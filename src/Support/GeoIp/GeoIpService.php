<?php

namespace Support\GeoIp;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Support\GeoIp\Contracts\GeoIpInterface;
use Support\GeoIp\DTOs\IpItemDTO;
use Support\GeoIp\Exceptions\GeoIpFailedDependencyException;

class GeoIpService implements GeoIpInterface
{
    /**
     * @var string|null
     */
    protected ?string $apiKey;

    /**
     * @var string|null
     */
    protected ?string $apiUrl;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->apiKey = $config['apiKey'] ?? null;
        $this->apiUrl = $config['apiUrl'] ?? null;
    }

    /**
     * @param string $ip
     *
     * @return IpItemDTO
     *
     * @throws \Support\GeoIp\Exceptions\GeoIpFailedDependencyException
     * */
    public function getIpInfo(string $ip): IpItemDTO
    {
        try {
            $response = Http::get($this->apiUrl, [
                'apiKey' => $this->apiKey,
                'ip' => $ip,
            ])->throw(function ($response, $e) {
                Log::error($e);
            })->json();
        } catch (RequestException) {
            throw new GeoIpFailedDependencyException();
        }

        return IpItemDTO::fromResponse($response);
    }
}
