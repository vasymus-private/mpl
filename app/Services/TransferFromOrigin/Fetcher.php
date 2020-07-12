<?php

namespace App\Services\TransferFromOrigin;

use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;

class Fetcher
{
    protected $url;

    protected $username;

    protected $password;

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null|mixed
     * */
    public function fetch()
    {
        if (!$this->url) throw new \LogicException("Fetch url is not provided");

        /** @var Builder $builder */
        $builder = Curl::to($this->url);
        $builder->withOption('USERPWD', "{$this->username}:{$this->password}");
        return $builder->get();
    }
}
