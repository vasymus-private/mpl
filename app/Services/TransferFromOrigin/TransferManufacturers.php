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

    /** @var string */
    protected $html;

    /**
     * @param string $site
     * @param Fetcher $fetcher
     * */
    public function __construct(string $site = "http://union.parket-lux.ru", $fetcher = null)
    {
        parent::__construct($site);
        $this->fetcher = $fetcher !== null ? $fetcher : new Fetcher();
        $this->fetcher->setUsername("parket");
        $this->fetcher->setPassword("parket");
    }

    public function transfer()
    {
        $raw = require(storage_path("app/seeds/manufacturers/raw.php"));

        $seeds = [];

        foreach ($raw as $rawItem) {
            $id = $this->getIncrementId();
            $preview = trim($rawItem["preview"]);
            $description = trim($rawItem["description"]);
            $image = !empty($rawItem["imageSrc"]) ? $this->fetchAndStoreImage($rawItem["imageSrc"], $id) : null;

            $seed = [
                "id" => $id,
                "name" => $rawItem["name"],
                "preview" => !empty($preview) ? $preview : strip_tags($description),
                "description" => !empty($description) ? $description : $preview,
                "image" => $image,
                "ordering" => (int) $rawItem["SORT"],
                "_old_id" => (int) $rawItem["id"],
            ];

            $seeds[] = $seed;
        }

        Storage::put("seeds/manufacturers/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Fetch image from site and store it on local disk
     *
     * @param string $location
     * @param int $itemId
     *
     * @return string Full image url on local disk
     * */
    public function fetchAndStoreImage(string $location, int $itemId): string
    {
        $this->pageUrl = $location;
        $extension = pathinfo($location)['extension'];

        $this->fetcher->setUrl($this->getUrl());
        $image = $this->fetcher->fetch();
        $path = "seeds/manufacturers/media/{$itemId}.$extension";
        $isSaved = Storage::put($path, $image);

        if (!$isSaved) throw new \RuntimeException("Failed to save image");

        return $path;
    }
}
