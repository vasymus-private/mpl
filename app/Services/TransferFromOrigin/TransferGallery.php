<?php

namespace App\Services\TransferFromOrigin;

use Illuminate\Support\Facades\Storage;

class TransferGallery extends BaseTransfer
{
    public function transfer()
    {
        $list = require(storage_path("app/seeds/photos/raw-list.php"));
        $seeds = [];

        foreach ($list as $item) {
            $id = $this->getIncrementId();
            $pageLink = $item["SECTION_PAGE_URL"];

            $seed = [
                "id" => $id,
                "name" => $item["NAME"],
                "description" => $item["DESCRIPTION"],
                "slug" => $item["CODE"],
                "_old_id" => $item["ID"],

            ];
        }
    }

    public function fetchAndStoreRaw(int $zeroBasedIndexStart = null)
    {
        $detailPageUrls = require(storage_path("app/seeds/photos/raw-list.php"));

        foreach ($detailPageUrls as $zeroBasedIndex => $item) {
            if ($zeroBasedIndex < $zeroBasedIndexStart) continue;

            $location = $item["SECTION_PAGE_URL"];
            $fileName = "$item[ID].php";

            $isSuccess = $this->fetchAndStoreRawItem($location, $fileName);

            if (!$isSuccess) {
                dump("Failed to fetch and store / parse $location | File name: $fileName");
            }
        }
    }

    public function fetchAndStoreRawItem(string $location, string $fileName): bool
    {
        if (Storage::exists("seeds/photos/gallery-items/$fileName")) {
            dump("File $fileName exists");
            return true;
        }

        $html = $this->fetchHtml($location);
        if (!$html) return false;

        $startFlag = "<!-----START----->";
        $endFlag = "<!-----END----->";

        $afterStartArr = explode($startFlag, $html);

        if (count($afterStartArr) < 2) {
            return false;
        }

        $afterStart = $afterStartArr[1];
        $arrayString = explode($endFlag, $afterStart)[0];

        $phpString = "<?php\n\nreturn $arrayString;";

        return Storage::put("seeds/photos/gallery-items/$fileName", $phpString);
    }
}
