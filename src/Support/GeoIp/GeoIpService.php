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
    protected $apiKey;

    protected $apiUrl;

    public function __construct(array $config)
    {
        $this->validateConfig($config);

        $this->apiKey = $config['apiKey'];
        $this->apiUrl = $config['apiUrl'];
    }

    /**
     * @param string $ip
     *
     * @return IpItemDTO
     *
     * @throws GeoIpFailedDependencyException
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
        } catch (RequestException $exception) {
            throw new GeoIpFailedDependencyException();
        }

        return IpItemDTO::fromResponse($response);
    }

    protected function validateConfig(array $config): bool
    {
        $apiKey = $config['apiKey'] ?? null;
        $apiUrl = $config['apiUrl'] ?? null;

        if (! $apiKey || ! $apiUrl) {
            throw new \LogicException("'apiKey' or 'apiUrl' not provided for GeoIp.");
        }

        return true;
    }
}
