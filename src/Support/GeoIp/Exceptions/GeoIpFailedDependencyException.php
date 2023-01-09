<?php


namespace Support\GeoIp\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class GeoIpFailedDependencyException extends HttpException
{
    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     *
     * @return void
     */
    public function __construct(string $message = null)
    {
        parent::__construct(424, $message ?: "Failed to execute GeoIp api request");
    }
}
