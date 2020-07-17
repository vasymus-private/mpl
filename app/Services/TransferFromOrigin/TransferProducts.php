<?php

namespace App\Services\TransferFromOrigin;

use App\Services\TransferFromOrigin\DTOs\ManufacturerDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class TransferProducts extends BaseTransfer
{
    /** @var Collection|null */
    protected $categories;

    /** @var Collection|null */
    protected $manufacturers;

    public function transfer()
    {
        $this->categories = collect(json_decode(Storage::get("seeds/categories/seeds.json"), true));
        $this->manufacturers = collect(json_decode(Storage::get("seeds/manufacturers/seeds.json")), true);

        $seeds = [];

        for ($i = 1; $i <= 11; $i++) {
            $raw = require(storage_path("app/seeds/products/raw-50-$i.php"));

            foreach ($raw as $rawItem) {

                if ($this->shouldIgnore($rawItem)) continue;

                $this->checkRawItem($rawItem);

                $id = $this->getIncrementId();
                $category = $this->categories->where("_old_id", (int)$rawItem["IBLOCK_SECTION_ID"])->first();

                $seed = [
                    "id" => $id,
                    "name" => $rawItem["NAME"],
                    "slug" => $rawItem["CODE"],
                    "ordering" => (int)$rawItem["SORT"],
                    "preview" => $rawItem["PREVIEW_TEXT"],
                    "description" => $rawItem["DETAIL_TEXT"],
                    "category_id" => (int)$category["id"],
                    "created_at" => null,

                    "_old_id" => (int)$rawItem["ID"],
                    "_old_category_id" => (int)$rawItem["IBLOCK_SECTION_ID"],
                ];

                $seed = array_merge($seed, $this->getSeedDataFromProperties($rawItem));
                $seed = array_merge($seed, $this->getSeedDataFromOffers($rawItem));

                $seeds[] = $seed;
            }
        }

        Storage::put("seeds/products/seeds.json", json_encode($seeds, JSON_UNESCAPED_UNICODE));
    }

    public function transferMediaToSeeds()
    {
        $raw = require(storage_path("app/seeds/products/raw-media.php"));
        $productsSeeds = collect(json_decode(Storage::get("seeds/products/seeds.json"), true));

        foreach ($raw as $rawItem) {
            $_oldProductId = (int)$rawItem["ID"];

            $productKey = $productsSeeds->search(function(array $pr) use($_oldProductId) {
                return (int)$pr["_old_id"] === $_oldProductId;
            });
            if ($productKey === false) continue;

            $product = $productsSeeds->get($productKey);

            $newProductId = (int)$product["id"];
            $files = $rawItem["media"]["files"];
            $images = $rawItem["media"]["images"];
            $mainImage = $rawItem["media"]["mainImage"];

            $storeFolder = $this->getStdStorageFolder("products");
            $storeFolder = "$storeFolder/$newProductId";

            $loop = function(string $type, array $rawFile) use($storeFolder, $newProductId, $_oldProductId): ?array {
                $src = $rawFile["SRC"];
                $originalName = $rawFile["ORIGINAL_NAME"] ?? basename($src);
                $extenstion = pathinfo($src)["extension"] ?? null;
                $_oldMediaId = (int)$rawFile["ID"];
                $newName = $extenstion ? "$_oldMediaId.$extenstion" : "$_oldMediaId";
                $storagePath = "$storeFolder/$type/$newName";

                $storedFile = $this->fetchAndStoreFileToPath($src, $storagePath);

                if (!$storedFile) return null;

                return [
                    "_old_id" => $_oldMediaId,
                    "name" => $originalName,
                    "src" => $storedFile,
                    "product_id" => $newProductId,
                    "_old_product_id" => $_oldProductId,
                ];
            };

            $media = [
                "mainImage" => null,
                "images" => [],
                "files" => [],
            ];
            $media["mainImage"] = $loop("mainImage", $mainImage);
            foreach ($images as $image) {
                $media["images"][] = $loop("images", $image);
            }
            foreach ($files as $file) {
                $media["files"][] = $loop("files", $file);
            }

            $product["media"] = $media;

            $productsSeeds->put($productKey, $product);

            dd($product);
        }

        Storage::put("seeds/products/seeds.json", json_encode($productsSeeds, JSON_UNESCAPED_UNICODE));
    }

    public function shouldIgnore(array $rawItem): bool
    {
        $category = $this->categories->where("_old_id", $rawItem["IBLOCK_SECTION_ID"])->first();
        /*if (!$category) {
            dump("No category with id $rawItem[IBLOCK_SECTION_ID] found for product with id $rawItem[ID] '$rawItem[NAME]'.");
        }*/
        return !$category || $rawItem['NAME'] === 'Доставка';
    }

    public function checkRawItem(array $rawItem): bool
    {
        $requiredFields = ['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID', 'SORT', 'PREVIEW_TEXT', 'DETAIL_TEXT'];

        foreach ($requiredFields as $field) {
            if (!isset($rawItem[$field])) throw new \LogicException("Wrong rawItem: No '$field' field in $rawItem[ID]");
        }


        return true;
    }

    protected function getSeedDataFromProperties(array $rawItem): array
    {
        $properties = $rawItem["PROPERTIES"];

        $oldManufacturerId = $properties["brand"]["VALUE"] ?? null;
        $manufacturer = $this->manufacturers->where("_old_id", $oldManufacturerId)->first();

        $loopProductProduct = function(array $otherProductsIds): array {
            $newOtherProductsIds = [];
            foreach ($otherProductsIds as $id) {
                $newOtherProduct = $this->categories->where("_old_id", $id)->first();
                if (!$newOtherProduct) {
                    dump("Failed to find other product with old id: $id");
                    continue;
                }
                $newOtherProductsIds[] = $newOtherProduct["id"];
            }
            return $newOtherProductsIds;
        };

        $oldAccessoriesIds = !empty($properties["accessories"]["VALUE"]) ? $properties["accessories"]["VALUE"] : [];
        $newAccessoriesIds = $loopProductProduct($oldAccessoriesIds);

        $oldSimilarIds = !empty($properties["similar"]["VALUE"]) ? $properties["similar"]["VALUE"] : [];
        $newSimilarIds = $loopProductProduct($oldSimilarIds);

        $oldRelatedIds = !empty($properties["sopr"]["VALUE"]) ? $properties["sopr"]["VALUE"] : [];
        $newRelatedIds = $loopProductProduct($oldRelatedIds);

        $oldWorksIds = !empty($properties["work"]["VALUE"]) ? $properties["work"]["VALUE"] : [];
        $newWorkIds = $loopProductProduct($oldWorksIds);

        $seo = [
            "h1" => $properties["custom_h1"]["VALUE"] ?? null,
            "title" => $properties["custom_title"]["VALUE"] ?? null,
            "keywords" => $properties["meta_keywords"]["VALUE"] ?? null,
            "description" => $properties["meta_description"]["VALUE"] ?? null,
        ];

        $coefficient = $properties["koef_price"]["VALUE"];
        $coefficient_description = $properties["koef_price"]["DESCRIPTION"];

        $price_name = $properties["rename_price"]["VALUE"];

        $informational_prices = [];
        $_oldInfoPrices = $properties["info_price"];
        $__ipValues = $_oldInfoPrices["VALUE"];
        $__ipDescriptions = $_oldInfoPrices["DESCRIPTION"];
        foreach ($__ipValues as $index => $infoPrice) {
            $informational_prices[] = [
                "price" => $infoPrice,
                "name" => $__ipDescriptions[$index] ?? null,
            ];
        }

        $admin_comment = $properties["auxiliary"]["VALUE"];

        $price_purchase = $properties["purchase"]["VALUE"];
        $price_purchase_currency_name = $properties["purchase"]["DESCRIPTION"];

        $unit = $properties["package"]["VALUE"];

        $is_in_stock = empty($properties["order"]["VALUE"]); // если не "на заказ", то значит, товар на складе

        return [
            "manufacturer_id" => $manufacturer ? $manufacturer["id"] : null,
            "seo" => $seo,
            "accessoriesIds" => $newAccessoriesIds,
            "similarIds" => $newSimilarIds,
            "relatedIds" => $newRelatedIds,
            "newWorkIds" => $newWorkIds,
            "coefficient" => $coefficient,
            "coefficient_description" => $coefficient_description,
            "price_name" => $price_name,
            "informational_prices" => $informational_prices,
            "admin_comment" => $admin_comment,
            "price_purchase" => $price_purchase,
            "price_purchase_currency_name" => $price_purchase_currency_name,
            "unit" => $unit,
            "is_in_stock" => $is_in_stock,


            "_old_manufacturer_id" => $oldManufacturerId,
            "_old_accessories_ids" => $oldAccessoriesIds,
            "_old_similar_ids" => $oldSimilarIds,
            "_old_related_ids" => $oldRelatedIds,
            "_old_work_ids" => $oldWorksIds,
        ];
    }

    protected function getSeedDataFromOffers(array $rawItem): array
    {
        $offers = $rawItem["OFFERS"];

        return [];
    }
}
