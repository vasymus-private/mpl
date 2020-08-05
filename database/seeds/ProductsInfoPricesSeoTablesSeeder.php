<?php

use App\Models\Currency;
use App\Models\InformationalPrice;
use App\Models\Pivots\CategoryProduct;
use App\Models\Pivots\ProductProduct;
use App\Models\Pivots\ProductUser;
use App\Models\Product\Product;
use App\Models\Seo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsInfoPricesSeoTablesSeeder extends Seeder
{
    /** @var array */
    protected $rawSeeds;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->truncate();
        ProductUser::query()->truncate();
        CategoryProduct::query()->truncate();
        ProductProduct::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->rawSeeds = json_decode(Storage::get("seeds/products/seeds.json"), true);

        $this->initialSeed();

        $this->seedRelations();
        $this->seedVariations();
    }

    protected function initialSeed()
    {
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
                if (!empty($rawSeed[$attribute])) {
                    if ($attribute === "manufacturer_id") {
                        $seed["brand_id"] = $rawSeed["manufacturer_id"];
                    } else {
                        $seed[$attribute] = $rawSeed[$attribute];
                    }
                }
            }
            $characteristics = $rawSeed["characteristics"] ?? [];
            foreach ($characteristics as $key => $characteristic) {
                if (!empty($characteristic)) $seed[$key] = $characteristic;
            }

            if (!empty($rawSeed["price_retail_currency_id"]))
                $seed["price_retail_currency_id"] = Currency::getIdByName($rawSeed["price_retail_currency_id"]);
            if (!empty($rawSeed["price_purchase_currency_name"])) // YES it's currency name -- RUB, EUR, USD we should put to price_purchase_currency_id -- it's not a typo
                $seed["price_purchase_currency_id"] = Currency::getIdByName($rawSeed["price_purchase_currency_name"]);

            $seed['is_with_variations'] = !empty($rawSeed["variations"]);

            if (empty($seed["slug"])) $seed["slug"] = str_slug($seed["name"]);

            $product = Product::forceCreate($seed);
            $this->seedSeo($product, $rawSeed["seo"]);
            $this->seedInfoPrices($product, $rawSeed["informational_prices"]);
            $this->seedMedia($product, $rawSeed["media"]);

        }
    }

    protected function seedRelations()
    {
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
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    protected function seedVariations()
    {
        foreach ($this->rawSeeds as $rawSeed) {
            /** @var Product $product */
            $product = Product::query()->findOrFail($rawSeed["id"]);

            if (empty($product["variations"])) continue;

            foreach ($product["variations"] as $variation) {
                $asIsAttributes = ["name", "price_retail", "ordering", "price_purchase", "is_active", "unit", "coefficient", "preview"];
                $seed = [];
                foreach ($asIsAttributes as $attribute) {
                    if (!empty($variation[$attribute])) $seed[$attribute] = $variation[$attribute];
                }
                if (!empty($variation["price_retail_currency_id"]))
                    $seed["price_retail_currency_id"] = Currency::getIdByName($variation["price_retail_currency_id"]);
                if (!empty($variation["price_purchase_currency_id"]))
                    $seed["price_purchase_currency_id"] = Currency::getIdByName($variation["price_purchase_currency_id"]);

                $seed["slug"] = str_slug($seed["name"]);
                $seed["is_active"] = true;
                $seed["parent_id"] = $rawSeed["id"];

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
                    $fileAdder->toMediaCollection(Product::MC_MAIN_IMAGE);
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
            $product
                ->addMedia(storage_path("app/$src"))
                ->preservingOriginal()
                ->usingName($name)
                ->sanitizingFileName(function($fileName) {
                    return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                })
                ->toMediaCollection($collectionName)
            ;
        };

        if ($media["mainImage"]) $loop($media["mainImage"], Product::MC_MAIN_IMAGE);
        foreach ($media["images"] as $mediaInfo) {
            $loop($mediaInfo, Product::MC_ADDITIONAL_IMAGES);
        }
        foreach ($media["files"] as $fileMediaInfo) {
            $loop($fileMediaInfo, Product::MC_FILES);
        }
    }
}
