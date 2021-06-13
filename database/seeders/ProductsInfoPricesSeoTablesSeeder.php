<?php

namespace Database\Seeders;

use Domain\Products\Models\AvailabilityStatus;
use Domain\Common\Models\Currency;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\CharType;
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
    protected const CH_NAME_DESC_TRADE_MARK = "Торговая марка";
    protected const CH_NAME_DESC_COUNTRY_NAME = "Страна производитель";
    protected const CH_NAME_DESC_UNIT = "Единица измерения";
    protected const CH_NAME_DESC_PACKING = "Фасовка";
    protected const CH_NAME_DESC_LIGHT_REFLECTION = "Светоотражение";
    protected const CH_NAME_DESC_MATERIAL_CONSUMPTION = "Расход материала";
    protected const CH_NAME_DESC_APPLY_INSTRUMENT = "Инструмент нанесения";
    protected const CH_NAME_DESC_PLACEMENT_TEMPERATURE_MOISTURE = "Температура и влажность в помещении";
    protected const CH_NAME_DESC_DRYING_TIME = "Время высыхания";
    protected const CH_NAME_DESC_SPECIAL_CHARACTERISTICS = "Особые свойства";
    protected const CH_NAME_COMPATIBILITY_WOOD_USUAL_RATE = "Обычные породы дерева";
    protected const CH_NAME_COMPATIBILITY_WOOD_EXOTIC_RATE = "Экзотические породы дерева";
    protected const CH_NAME_COMPATIBILITY_WOOD_CORK_RATE = "Пробковые покрытия";
    protected const CH_NAME_SUITABILITY_PARQUET_PIECE_RATE = "Штучный паркет";
    protected const CH_NAME_SUITABILITY_PARQUET_MASSIVE_BOARD_RATE = "Массивная доска";
    protected const CH_NAME_SUITABILITY_PARQUET_BOARD_RATE = "Паркетная доска";
    protected const CH_NAME_SUITABILITY_PARQUET_ART_RATE = "Художественный паркет";
    protected const CH_NAME_SUITABILITY_PARQUET_LAMINATE_RATE = "Ламинат";
    protected const CH_NAME_SUITABILITY_PLACEMENT_LIVING_RATE = "Жилые помещения";
    protected const CH_NAME_SUITABILITY_PLACEMENT_OFFICE_RATE = "Офисы";
    protected const CH_NAME_SUITABILITY_PLACEMENT_RESTAURANT_RATE = "Рестораны";
    protected const CH_NAME_SUITABILITY_PLACEMENT_CHILD_AND_MEDICAL_RATE = "Детские и лечебные учреждения";
    protected const CH_NAME_SUITABILITY_PLACEMENT_GYM_RATE = "Спортзалы";
    protected const CH_NAME_SUITABILITY_PLACEMENT_INDUSTRIAL_ZONE_RATE = "Промышленные зоны";
    protected const CH_NAME_EXPLOITATION_ABRASION_RESISTANCE_RATE = "Стойкость к истиранию";
    protected const CH_NAME_EXPLOITATION_SURFACE_FIRMNESS_RATE = "Поверхностная твердость";
    protected const CH_NAME_EXPLOITATION_ELASTICITY_RATE = "Эластичность";
    protected const CH_NAME_EXPLOITATION_SUSTAIN_UV_RAYS_RATE = "Устойчивость к УФ лучам";
    protected const CH_NAME_EXPLOITATION_SUSTAIN_CHEMICALS_RATE = "Устойчивость к химикатам";
    protected const CH_NAME_EXPLOITATION_AFTER_APPLY_WOOD_COLOR = "Цвет древесины после нанесения";
    protected const CH_NAME_EXPLOITATION_ENV_FRIENDLINESS = "Экологичность";
    protected const CH_NAME_STORAGE_TERM = "Срок хранения";
    protected const CH_NAME_STORAGE_CONDITIONS = "Условия хранения";

    protected const CH_GROUP_DESCRIPTION = "Описание товара";
    protected const CH_GROUP_COMPATIBILITY_WOOD = "Совместимость с породой дерева (максимальная оценка - 5 баллов)";
    protected const CH_GROUP_SUITABILITY_PARQUET = "Пригодность для типов паркета (максимальная оценка - 5 баллов)";
    protected const CH_GROUP_SUITABILITY_PLACEMENT = "Пригодность для типов помещений (максимальная оценка - 5 баллов)";
    protected const CH_GROUP_EXPLOITATION = "Эксплуатационные характеристики (максимальная оценка - 5 баллов)";
    protected const CH_GROUP_STORAGE = "Хранение";

    protected const CH_RATE = [
        self::CH_NAME_COMPATIBILITY_WOOD_USUAL_RATE,
        self::CH_NAME_COMPATIBILITY_WOOD_EXOTIC_RATE,
        self::CH_NAME_COMPATIBILITY_WOOD_CORK_RATE,
        self::CH_NAME_SUITABILITY_PARQUET_PIECE_RATE,
        self::CH_NAME_SUITABILITY_PARQUET_MASSIVE_BOARD_RATE,
        self::CH_NAME_SUITABILITY_PARQUET_BOARD_RATE,
        self::CH_NAME_SUITABILITY_PARQUET_ART_RATE,
        self::CH_NAME_SUITABILITY_PARQUET_LAMINATE_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_LIVING_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_OFFICE_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_RESTAURANT_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_CHILD_AND_MEDICAL_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_GYM_RATE,
        self::CH_NAME_SUITABILITY_PLACEMENT_INDUSTRIAL_ZONE_RATE,
        self::CH_NAME_EXPLOITATION_ABRASION_RESISTANCE_RATE,
        self::CH_NAME_EXPLOITATION_SURFACE_FIRMNESS_RATE,
        self::CH_NAME_EXPLOITATION_ELASTICITY_RATE,
        self::CH_NAME_EXPLOITATION_SUSTAIN_UV_RAYS_RATE,
        self::CH_NAME_EXPLOITATION_SUSTAIN_CHEMICALS_RATE,
    ];

    protected const CHARACTERISTICS = [
        self::CH_GROUP_DESCRIPTION => [
            self::CH_NAME_DESC_TRADE_MARK => "ch_desc_trade_mark",
            self::CH_NAME_DESC_COUNTRY_NAME => "ch_desc_country_name",
            self::CH_NAME_DESC_UNIT => "ch_desc_unit",
            self::CH_NAME_DESC_PACKING => "ch_desc_packing",
            self::CH_NAME_DESC_LIGHT_REFLECTION => "ch_desc_light_reflection",
            self::CH_NAME_DESC_MATERIAL_CONSUMPTION => "ch_desc_material_consumption",
            self::CH_NAME_DESC_APPLY_INSTRUMENT => "ch_desc_apply_instrument",
            self::CH_NAME_DESC_PLACEMENT_TEMPERATURE_MOISTURE => "ch_desc_placement_temperature_moisture",
            self::CH_NAME_DESC_DRYING_TIME => "ch_desc_drying_time",
            self::CH_NAME_DESC_SPECIAL_CHARACTERISTICS => "ch_desc_special_characteristics",
        ],
        self::CH_GROUP_COMPATIBILITY_WOOD => [
            self::CH_NAME_COMPATIBILITY_WOOD_USUAL_RATE => "ch_compatibility_wood_usual_rate",
            self::CH_NAME_COMPATIBILITY_WOOD_EXOTIC_RATE => "ch_compatibility_wood_exotic_rate",
            self::CH_NAME_COMPATIBILITY_WOOD_CORK_RATE => "ch_compatibility_wood_cork_rate",
        ],
        self::CH_GROUP_SUITABILITY_PARQUET => [
            self::CH_NAME_SUITABILITY_PARQUET_PIECE_RATE => "ch_suitability_parquet_piece_rate",
            self::CH_NAME_SUITABILITY_PARQUET_MASSIVE_BOARD_RATE => "ch_suitability_parquet_massive_board_rate",
            self::CH_NAME_SUITABILITY_PARQUET_BOARD_RATE => "ch_suitability_parquet_board_rate",
            self::CH_NAME_SUITABILITY_PARQUET_ART_RATE => "ch_suitability_parquet_art_rate",
            self::CH_NAME_SUITABILITY_PARQUET_LAMINATE_RATE => "ch_suitability_parquet_laminate_rate",
        ],
        self::CH_GROUP_SUITABILITY_PLACEMENT => [
            self::CH_NAME_SUITABILITY_PLACEMENT_LIVING_RATE => "ch_suitability_placement_living_rate",
            self::CH_NAME_SUITABILITY_PLACEMENT_OFFICE_RATE => "ch_suitability_placement_office_rate",
            self::CH_NAME_SUITABILITY_PLACEMENT_RESTAURANT_RATE => "ch_suitability_placement_restaurant_rate",
            self::CH_NAME_SUITABILITY_PLACEMENT_CHILD_AND_MEDICAL_RATE => "ch_suitability_placement_child_and_medical_rate",
            self::CH_NAME_SUITABILITY_PLACEMENT_GYM_RATE => "ch_suitability_placement_gym_rate",
            self::CH_NAME_SUITABILITY_PLACEMENT_INDUSTRIAL_ZONE_RATE => "ch_suitability_placement_industrial_zone_rate",
        ],
        self::CH_GROUP_EXPLOITATION => [
            self::CH_NAME_EXPLOITATION_ABRASION_RESISTANCE_RATE => "ch_exploitation_abrasion_resistance_rate",
            self::CH_NAME_EXPLOITATION_SURFACE_FIRMNESS_RATE => "ch_exploitation_surface_firmness_rate",
            self::CH_NAME_EXPLOITATION_ELASTICITY_RATE => "ch_exploitation_elasticity_rate",
            self::CH_NAME_EXPLOITATION_SUSTAIN_UV_RAYS_RATE => "ch_exploitation_sustain_uv_rays_rate",
            self::CH_NAME_EXPLOITATION_SUSTAIN_CHEMICALS_RATE => "ch_exploitation_sustain_chemicals_rate",
            self::CH_NAME_EXPLOITATION_AFTER_APPLY_WOOD_COLOR => "ch_exploitation_after_apply_wood_color",
            self::CH_NAME_EXPLOITATION_ENV_FRIENDLINESS => "ch_exploitation_env_friendliness",
        ],
        self::CH_GROUP_STORAGE => [
            self::CH_NAME_STORAGE_TERM => "ch_storage_term",
            self::CH_NAME_STORAGE_CONDITIONS => "ch_storage_conditions",
        ],
    ];

    /**
     * @var array
     */
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
                        case $attribute === "is_available":
                        case $attribute === "is_in_stock" : {
                            $seed['availability_status_id'] = rand(1, 3);
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
                $this->seedCharCategoriesAndChars($product, $rawSeed);
            } catch (\Exception $exception) {
                dd($exception->getMessage(), $seed);
            }

            $this->seedSeo($product, $rawSeed["seo"]);
            $this->seedInfoPrices($product, $rawSeed["informational_prices"]);
            $this->seedMedia($product, $rawSeed["media"]);

        }
    }

    protected function seedCharCategoriesAndChars(Product $product, array $rawSeed)
    {
        $characteristics = $rawSeed["characteristics"] ?? [];

        /** @var \Domain\Products\Models\CharCategory[] $charCategoriesByName */
        $charCategoriesByName = [];

        foreach ($characteristics as $key => $charValue) {
            if ($charValue === null || $charValue === '') {
                continue;
            }
            foreach (static::CHARACTERISTICS as $groupName => $chars) {
                foreach ($chars as $charName => $charColumn) {
                    if ($key !== $charColumn) {
                        continue;
                    }
                    if (isset($charCategoriesByName[$groupName])) {
                        $charCategory = $charCategoriesByName[$groupName];
                    } else {
                        $charCategory = $charCategoriesByName[$groupName] = CharCategory::forceCreate([
                            'name' => $groupName,
                            'product_id' => $product->id,
                        ]);
                    }

                    Char::forceCreate([
                        'name' => $charName,
                        'product_id' => $product->id,
                        'category_id' => $charCategory->id,
                        'type_id' => in_array($charName, static::CH_RATE) ? CharType::ID_RATE : CharType::ID_TEXT,
                        'value' => $charValue,
                    ]);
                }
            }
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

                $seed['availability_status_id'] = rand(1, 3);
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
