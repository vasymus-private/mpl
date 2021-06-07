<?php

namespace Database\Seeders;

use Domain\Products\Models\AvailabilityStatus;
use Domain\Common\Models\Currency;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Pivots\CategoryProduct;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Users\Models\Pivots\ProductUserAside;
use Domain\Users\Models\Pivots\ProductUserCart;
use Domain\Users\Models\Pivots\ProductUserViewed;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;

class ProductsInfoPricesSeoTablesSeeder extends Seeder
{
    /** @var array */
    protected $rawSeeds;

    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->truncate();
        ProductUserAside::query()->truncate();
        ProductUserViewed::query()->truncate();
        ProductUserCart::query()->truncate();
        CategoryProduct::query()->truncate();
        ProductProduct::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->rawSeeds = json_decode(Storage::get("seeds/products/seeds.json"), true);

        $this->initialSeed();

        $this->seedRelations();
        $this->seedVariations();

        $this->seedProductIsWithVariants();
    }

    protected function initialSeed()
    {
        dump("initial seeding");
        foreach ($this->rawSeeds as $rawSeed) {
            $asIsAttributes = [
                "id",
                "name",
                "slug",
                "ordering",
                "preview",
                "description",
                "is_active",
                "category_id",
                "manufacturer_id",
                "coefficient",
                "coefficient_description",
                "price_name",
                "admin_comment",
                "price_purchase",
                "unit",
                "is_in_stock",
                "is_available",
                "price_retail",
            ];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                if (($rawSeed[$attribute] ?? null) !== null) {
                    switch (true) {
                        case $attribute === "manufacturer_id" : {
                            $seed["brand_id"] = $rawSeed["manufacturer_id"];
                            break;
                        }
                        case $attribute === "is_in_stock" : {
                            if ($rawSeed[$attribute]) $seed["availability_status_id"] = AvailabilityStatus::ID_AVAILABLE_IN_STOCK;
                            else $seed["availability_status_id"] = AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK;
                            break;
                        }
                        case $attribute === "is_available" : {
                            if (!$rawSeed[$attribute]) {
                                $seed["availability_status_id"] = AvailabilityStatus::ID_NOT_AVAILABLE;
                            }
                            break;
                        }
                        case $attribute === "price_purchase" :
                        case $attribute === "coefficient" : {
                            $seed[$attribute] = !empty($rawSeed[$attribute]) ? $rawSeed[$attribute] : null;
                            break;
                        }
                        default : {
                            $seed[$attribute] = $rawSeed[$attribute];
                            break;
                        }
                    }
                }
            }

            if (empty($seed["price_retail"])) {
                $pricePurchase = $rawSeed["price_purchase"] ?? null;
                if ($pricePurchase) {
                    $seed[$attribute] = $pricePurchase + ($pricePurchase / 4);
                } else {
                    $seed[$attribute] = null;
                }
            }

            $seed["is_active"] = true;

            $characteristics = $rawSeed["characteristics"] ?? [];
            foreach ($characteristics as $key => $characteristic) {
                if (!empty($characteristic)) $seed[$key] = $characteristic;
            }

            if (!empty($rawSeed["price_retail_currency_id"]))
                $seed["price_retail_currency_id"] = Currency::getIdByName($rawSeed["price_retail_currency_id"]);
            if (!empty($rawSeed["price_purchase_currency_name"])) // YES it's currency name -- RUB, EUR, USD we should put to price_purchase_currency_id -- it's not a typo
                $seed["price_purchase_currency_id"] = Currency::getIdByName($rawSeed["price_purchase_currency_name"]);

            if (empty($seed["price_retail_currency_id"])) {
                $pricePurchaseCurrencyId = $seed["price_purchase_currency_id"] ?? null;
                if ($pricePurchaseCurrencyId) {
                    $seed["price_retail_currency_id"] = $pricePurchaseCurrencyId;
                }
            }

            if (empty($seed["slug"])) $seed["slug"] = str_slug($seed["name"]);

            try {
                $product = Product::forceCreate($seed);
            } catch (\Exception $exception) {
                dd($exception->getMessage(), $seed);
            }

            $this->seedSeo($product, $rawSeed["seo"]);
            $this->seedInfoPrices($product, $rawSeed["informational_prices"]);
            $this->seedMedia($product, $rawSeed["media"]);

        }
    }

    protected function seedRelations()
    {
        dump("seed relations");

        foreach ($this->rawSeeds as $rawSeed) {
            /** @var Product $product */
            $product = Product::query()->findOrFail($rawSeed["id"]);

            $loop = function(array $ids, int $type): ?array {
                if (empty($ids)) return null;

                return Product::query()
                    ->whereIn(Product::TABLE . ".id", $ids)
                    ->pluck("id")
                    ->reduce(function(array $acc, int $id) use($type) {
                        $acc[$id] = ["type" => $type];
                        return $acc;
                    }, []);
            };

            $accessoriesSync = $loop($rawSeed["accessoriesIds"] ?? [], ProductProduct::TYPE_ACCESSORY);
            if ($accessoriesSync) $product->accessory()->sync($accessoriesSync);

            $similarSync = $loop($rawSeed["similarIds"] ?? [], ProductProduct::TYPE_SIMILAR);
            if ($similarSync) $product->similar()->sync($similarSync);

            $relatedSync = $loop($rawSeed["relatedIds"] ?? [], ProductProduct::TYPE_RELATED);
            if ($relatedSync) $product->related()->sync($relatedSync);

            $workSync = $loop($rawSeed["workIds"] ?? [], ProductProduct::TYPE_WORK);
            if ($workSync) $product->works()->sync($workSync);
        }
    }

    /**
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    protected function seedVariations()
    {
        dump("seed variations");

        foreach ($this->rawSeeds as $rawSeed) {
            /** @var Product $parentProduct */
            $parentProduct = Product::query()->findOrFail($rawSeed["id"]);

            if (empty($rawSeed["variations"])) continue;

            foreach ($rawSeed["variations"] as $variation) {
                $asIsAttributes = ["name", "price_retail", "ordering", "price_purchase", "is_active", "unit", "coefficient", "preview"];
                $seed = [];
                foreach ($asIsAttributes as $attribute) {
                    if (!empty($variation[$attribute])) $seed[$attribute] = $variation[$attribute];
                }
                if (!empty($variation["price_retail_currency_id"]))
                    $seed["price_retail_currency_id"] = Currency::getIdByName($variation["price_retail_currency_id"]);
                if (!empty($variation["price_purchase_currency_id"]))
                    $seed["price_purchase_currency_id"] = Currency::getIdByName($variation["price_purchase_currency_id"]);

                $seed["is_active"] = true;
                $seed["parent_id"] = $parentProduct["id"];

                $product = Product::forceCreate($seed);

                if (!empty($variation["image"]["src"])) {
                    $src = $variation["image"]["src"];
                    $name = $variation["image"]["name"];
                    $fileAdder = $product
                        ->addMedia(storage_path("app/$src"))
                        ->preservingOriginal()
                    ;
                    if (!empty($name)) {
                        $fileAdder
                            ->usingName($name)
                            ->sanitizingFileName(function($fileName) {
                                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                            })
                        ;
                    }
                    try {
                        $fileAdder->toMediaCollection(Product::MC_MAIN_IMAGE);
                    } catch (NotReadableException $exception) {
                        dump($exception->getMessage());
                    }
                }
            }
        }
    }

    protected function seedSeo(Product $product, array $seo)
    {
        if (empty($seo["h1"]) && $seo["title"] && $seo["keywords"] && $seo["description"]) return;

        $seoM = $product->seo ?: new Seo();

        if (!empty($seo["h1"])) {
            $seoM->h1 = Str::limit($seo["h1"], 188);
        }
        if (!empty($seo["title"])) {
            $seoM->title =  Str::limit($seo["title"], 188);
        }
        if (!empty($seo["keywords"])) {
            $seoM->keywords = $seo["keywords"];
        }
        if (!empty($seo["description"])) {
            $seoM->description = $seo["description"];
        }

        $product->seo()->save($seoM);
    }

    protected function seedInfoPrices(Product $product, array $infoPrices)
    {
        $models = [];
        foreach ($infoPrices as $infoPrice) {
            $infoPriceM = new InformationalPrice();
            $infoPriceM->name = $infoPrice["name"];
            $infoPriceM->price = $infoPrice["price"];
            $models[] = $infoPriceM;
        }
        $product->infoPrices()->saveMany($models);
    }

    protected function seedMedia(Product $product, array $media)
    {
        $loop = function(array $mediaInfo, string $collectionName) use($product) {
            $src = $mediaInfo["src"];
            $name = $mediaInfo["name"];
            try {
                $product
                    ->addMedia(storage_path("app/$src"))
                    ->preservingOriginal()
                    ->usingName($name)
                    ->sanitizingFileName(function($fileName) {
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })
                    ->toMediaCollection($collectionName)
                ;
            } catch (NotReadableException $exception) {
                dump($exception->getMessage());
            }

        };

        if ($media["mainImage"]) $loop($media["mainImage"], Product::MC_MAIN_IMAGE);
        foreach ($media["images"] as $mediaInfo) {
            $loop($mediaInfo, Product::MC_ADDITIONAL_IMAGES);
        }
        foreach ($media["files"] as $fileMediaInfo) {
            $loop($fileMediaInfo, Product::MC_FILES);
        }
    }

    protected function seedProductIsWithVariants()
    {
        Product::query()->whereHas('variations')->update([
            'is_with_variations' => 1
        ]);
    }
}
