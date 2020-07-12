<?php

namespace App\Services\TransferFromOrigin;

use App\Services\TransferFromOrigin\DTOs\ManufacturerDTO;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class TransferManufacturers extends BaseTransfer
{
    /** @var Fetcher */
    protected $fetcher;

    /** @var ManufacturerDTO[] */
    protected $payload = [];

    /** @var Crawler */
    protected $crawler;

    /**
     * @param string $site
     * @param Fetcher $fetcher
     * */
    public function __construct(string $site, $fetcher = null)
    {
        parent::__construct($site);
        $this->pageUrl = "brands/index.php";
        $this->fetcher = $fetcher !== null ? $fetcher : new Fetcher();
        $this->fetcher->setUsername("parket");
        $this->fetcher->setPassword("parket");
    }

    public function transfer()
    {
        $html = $this->fetcher->fetch($this->getUrl());
        if (empty($html)) throw new \RuntimeException("Failed to fetch transfer page: '{$this->getUrl()}'");

        $this->parsePage($html);
    }

    public function parsePage(string $html)
    {
        $this->crawler = new Crawler($html);

    }

    public function payloadToStorage()
    {
        $current = Storage::exists("seeds/manufacturers/seeds.json") ? json_decode(Storage::get("seeds/manufacturers/seeds.json"), true) : [];
    }
}
