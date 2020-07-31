<?php

namespace App\Services\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferServicesAndArticles extends BaseTransfer
{
    /**
     * @param string|null $site
     * @param string|null $username
     * @param string|null $password
     * @param Fetcher|null $fetcher
     * */
    public function __construct(?string $site = "http://union.parket-lux.ru", string $username = "parket", string $password = "parket", $fetcher = null)
    {
        parent::__construct("https://parket-lux.ru", null, null, $fetcher);
    }


    public function transfer()
    {
        $raw = require(storage_path("app/seeds/pages/raw.php"));

        $seeds = [];

        foreach ($raw as $item) {

        }

        Storage::put("seeds/pages/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    public function fetchAndStoreHtml(string $url): ?string
    {
        $html = $this->fetchHtml($url);
        if (!$html) {
            dump("Failed to fetch html $url");
            return null;
        }
        if ($this->isArticle($url)) {
            $path = "seeds/pages/articles/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $html);

        } else {
            $path = "seeds/pages/services/" . basename($url) . ".html";
            $isSaved = Storage::put($path, $html);
        }

        if (!$isSaved) {
            dump("Failed to save html $url");
            return null;
        }
        return $path;
    }

    protected function isArticle(string $url): bool
    {
        return str_contains($url, "articles");
    }

    public function fetchAndStoreImage(string $url): ?string
    {
        return $this->fetchAndStoreFileToPath($url, "seeds/pages/images/" . ltrim($url, "/\\"));
    }
}
