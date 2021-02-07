<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Collections\ProductCollection;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\H;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Common\Models\BaseModel;
use Domain\Products\Models\Category;
use Domain\Common\Models\Currency;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Users\Models\Pivots\ProductUserAside;
use Domain\Users\Models\Pivots\ProductUserCart;
use Domain\Users\Models\Pivots\ProductUserViewed;
use Domain\Users\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property bool $is_with_variations
 * @property int $category_id
 * @property int|null $ordering
 * @property bool $is_active
 * @property int|null $brand_id
 * @property string|null $coefficient
 * @property string|null $coefficient_description
 * @property bool $coefficient_description_show
 * @property string|null $price_name
 * @property string|null $admin_comment
 * @property string|null $price_purchase
 * @property int|null $price_purchase_currency_id
 * @property string|null $unit
 * @property string|null $price_retail
 * @property int|null $price_retail_currency_id
 * @property int $availability_status_id
 * @property string|null $preview
 * @property string|null $description
 * @property string|null $ch_desc_trade_mark
 * @property string|null $ch_desc_country_name
 * @property string|null $ch_desc_unit
 * @property string|null $ch_desc_packing
 * @property string|null $ch_desc_light_reflection
 * @property string|null $ch_desc_material_consumption
 * @property string|null $ch_desc_apply_instrument
 * @property string|null $ch_desc_placement_temperature_moisture
 * @property string|null $ch_desc_drying_time
 * @property string|null $ch_desc_special_characteristics
 * @property int|null $ch_compatibility_wood_usual_rate
 * @property int|null $ch_compatibility_wood_exotic_rate
 * @property int|null $ch_compatibility_wood_cork_rate
 * @property int|null $ch_suitability_parquet_piece_rate
 * @property int|null $ch_suitability_parquet_massive_board_rate
 * @property int|null $ch_suitability_parquet_board_rate
 * @property int|null $ch_suitability_parquet_art_rate
 * @property int|null $ch_suitability_parquet_laminate_rate
 * @property int|null $ch_suitability_placement_living_rate
 * @property int|null $ch_suitability_placement_office_rate
 * @property int|null $ch_suitability_placement_restaurant_rate
 * @property int|null $ch_suitability_placement_child_and_medical_rate
 * @property int|null $ch_suitability_placement_gym_rate
 * @property int|null $ch_suitability_placement_industrial_zone_rate
 * @property int|null $ch_exploitation_abrasion_resistance_rate
 * @property int|null $ch_exploitation_surface_firmness_rate
 * @property int|null $ch_exploitation_elasticity_rate
 * @property int|null $ch_exploitation_sustain_uv_rays_rate
 * @property int|null $ch_exploitation_sustain_chemicals_rate
 * @property string|null $ch_exploitation_after_apply_wood_color
 * @property string|null $ch_exploitation_env_friendliness
 * @property string|null $ch_storage_term
 * @property string|null $ch_storage_conditions
 *
 * @property string $accessory_name
 * @property string $similar_name
 * @property string $related_name
 * @property string $work_name
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @mixin ProductRelations
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property OrderProduct|null $order_product
 *
 * @see User::cart()
 * @property ProductUserCart|null $cart_product
 *
 * @see User::viewed()
 * @property \Domain\Users\Models\Pivots\ProductUserViewed|null $viewed_product
 *
 * @see User::aside()
 * @property \Domain\Users\Models\Pivots\ProductUserAside|null $aside_product
 *
 * @see Product::scopeActive()
 * @method static static|Builder active()
 *
 * @see Product::scopeAvailable()
 * @method static static|Builder available()
 *
 * @see Product::scopeNotVariations()
 * @method static static|Builder notVariations()
 *
 * @see Product::scopeVariations()
 * @method static static|Builder variations()
 *
 * @see Product::scopeDoesntHaveVariations()
 * @method static static|Builder doesntHaveVariations()
 *
 * @see Product::getPriceRetailCurrencyNameAttribute()
 * @property string|null $price_retail_currency_name
 *
 * @see Product::getIsAvailableAttribute()
 * @property bool $is_available
 *
 * @see Product::getIsAvailableInStockAttribute()
 * @property bool $is_available_in_stock
 *
 * @see Product::getAvailableSubmitLabelAttribute()
 * @property string $available_submit_label
 *
 * @see Producet::getIsAvailableNotInStockAttribute()
 * @property bool $is_available_not_in_stock
 *
 * @see Product::getAvailabilityStatusNameAttribute()
 * @property string $availability_status_name
 *
 * @see Product::getPriceRetailRubAttribute()
 * @property float|null $price_retail_rub
 *
 * @see Product::getPriceRetailRubFormattedAttribute()
 * @property string $price_retail_rub_formatted
 *
 * @see Product::getPricePurchaseRubAttribute()
 * @property float|null $price_purchase_rub
 *
 * @see Product::getPricePurchaseRubFormattedAttribute()
 * @property string $price_purchase_rub_formatted
 *
 * @see Product::getCoefficientPriceRubAttribute()
 * @property float|null $coefficient_price_rub
 *
 * @see Product::getCoefficientPriceRubFormattedAttribute()
 * @property string $coefficient_price_rub_formatted
 *
 * @see Product::getMarginRubAttribute()
 * @property float|null $margin_rub
 *
 * @see Product::getMarginRubFormattedAttribute()
 * @property string $margin_rub_formatted
 *
 * @see Product::getPriceMarkupAttribute()
 * @property float|null $price_markup
 *
 * @see Product::getPriceIncomeAttribute()
 * @property float|null $price_income
 *
 * @see Product::getIsVariationAttribute()
 * @property bool $is_variation
 *
 * @see Product::getWebRouteAttribute()
 * @property string $web_route
 *
 * @see Product::getIsInCartAttribute()
 * @property bool|null $is_in_cart
 *
 * @see Product::getMainImageUrlAttribute()
 * @property string $main_image_url
 *
 * @see Product::getMainImageXsThumbUrlAttribute()
 * @property string $main_image_xs_thumb_url
 *
 * @see Product::getMainImageSmThumbUrlAttribute()
 * @property string $main_image_sm_thumb_url
 *
 * @see Product::getMainImageMdThumbUrlAttribute()
 * @property string $main_image_md_thumb_url
 *
 * @see Product::getMainImageLgThumbUrlAttribute()
 * @property string $main_image_lg_thumb_url
 *
 * @see Product::getImagesUrlsAttribute()
 * @property string[] $images_urls
 *
 * @see Product::getImagesXsThumbsUrlsAttribute()
 * @property string[] $images_xs_thumbs_urls
 *
 * @see Product::getImagesSmThumbsUrlsAttribute()
 * @property string[] $images_sm_thumbs_urls
 *
 * @see Product::getImagesMdThumbsUrlsAttribute()
 * @property string[] $images_md_thumbs_urls
 *
 * @see Product::getImagesLgThumbsUrlsAttribute()
 * @property string[] $images_lg_thumbs_urls
 *
 * @see Product::getOrderProductCountAttribute()
 * @property-read int|null $order_product_count
 *
 * @see Product::getOrderProductPriceRetailRubAttribute()
 * @property-read float|null $order_product_price_retail_rub
 *
 * @see Product::getOrderProductPriceRetailRubFormattedAttribute()
 * @property-read string|null $order_product_price_retail_rub_formatted
 *
 * @see Product::getOrderProductPriceRetailRubSumAttribute()
 * @property-read float|null $order_product_price_retail_rub_sum
 *
 * @see Product::getOrderProductPriceRetailRubSumFormattedAttribute()
 * @property-read string|null $order_product_price_retail_rub_sum_formatted
 **/
class Product extends BaseModel implements HasMedia
{
    use ProductRelations;
    use SoftDeletes;
    use InteractsWithMedia;

    const DEFAULT_CURRENCY_ID = Currency::ID_RUB;

    const TABLE = "products";
    const MAX_CHARACTERISTIC_RATE = 5;

    const MC_MAIN_IMAGE = "main";
    const MC_ADDITIONAL_IMAGES = "images";
    const MC_FILES = "files";

    const MCONV_XS_THUMB = "xs-thumb"; // 40x40
    const MCONV_XS_THUMB_SIZE = 40;
    const MCONV_SM_THUMB = "sm-thumb"; // 50x50
    const MCONV_SM_THUMB_SIZE = 50;
    const MCONV_MD_THUMB = "md-thumb"; // 120x120
    const MCONV_MD_THUMB_SIZE = 120;
    const MCONV_LG_THUMB = "lg-thumb"; // 220x220
    const MCONV_LG_THUMB_SIZE = 220;
    const MCONV_FILL_BG = "ffffff";


    const CH_NAME_DESC_TRADE_MARK = "Торговая марка";
    const CH_NAME_DESC_COUNTRY_NAME = "Страна производитель";
    const CH_NAME_DESC_UNIT = "Единица измерения";
    const CH_NAME_DESC_PACKING = "Фасовка";
    const CH_NAME_DESC_LIGHT_REFLECTION = "Светоотражение";
    const CH_NAME_DESC_MATERIAL_CONSUMPTION = "Расход материала";
    const CH_NAME_DESC_APPLY_INSTRUMENT = "Инструмент нанесения";
    const CH_NAME_DESC_PLACEMENT_TEMPERATURE_MOISTURE = "Температура и влажность в помещении";
    const CH_NAME_DESC_DRYING_TIME = "Время высыхания";
    const CH_NAME_DESC_SPECIAL_CHARACTERISTICS = "Особые свойства";
    const CH_NAME_COMPATIBILITY_WOOD_USUAL_RATE = "Обычные породы дерева";
    const CH_NAME_COMPATIBILITY_WOOD_EXOTIC_RATE = "Экзотические породы дерева";
    const CH_NAME_COMPATIBILITY_WOOD_CORK_RATE = "Пробковые покрытия";
    const CH_NAME_SUITABILITY_PARQUET_PIECE_RATE = "Штучный паркет";
    const CH_NAME_SUITABILITY_PARQUET_MASSIVE_BOARD_RATE = "Массивная доска";
    const CH_NAME_SUITABILITY_PARQUET_BOARD_RATE = "Паркетная доска";
    const CH_NAME_SUITABILITY_PARQUET_ART_RATE = "Художественный паркет";
    const CH_NAME_SUITABILITY_PARQUET_LAMINATE_RATE = "Ламинат";
    const CH_NAME_SUITABILITY_PLACEMENT_LIVING_RATE = "Жилые помещения";
    const CH_NAME_SUITABILITY_PLACEMENT_OFFICE_RATE = "Офисы";
    const CH_NAME_SUITABILITY_PLACEMENT_RESTAURANT_RATE = "Рестораны";
    const CH_NAME_SUITABILITY_PLACEMENT_CHILD_AND_MEDICAL_RATE = "Детские и лечебные учреждения";
    const CH_NAME_SUITABILITY_PLACEMENT_GYM_RATE = "Спортзалы";
    const CH_NAME_SUITABILITY_PLACEMENT_INDUSTRIAL_ZONE_RATE = "Промышленные зоны";
    const CH_NAME_EXPLOITATION_ABRASION_RESISTANCE_RATE = "Стойкость к истиранию";
    const CH_NAME_EXPLOITATION_SURFACE_FIRMNESS_RATE = "Поверхностная твердость";
    const CH_NAME_EXPLOITATION_ELASTICITY_RATE = "Эластичность";
    const CH_NAME_EXPLOITATION_SUSTAIN_UV_RAYS_RATE = "Устойчивость к УФ лучам";
    const CH_NAME_EXPLOITATION_SUSTAIN_CHEMICALS_RATE = "Устойчивость к химикатам";
    const CH_NAME_EXPLOITATION_AFTER_APPLY_WOOD_COLOR = "Цвет древесины после нанесения";
    const CH_NAME_EXPLOITATION_ENV_FRIENDLINESS = "Экологичность";
    const CH_NAME_STORAGE_TERM = "Срок хранения";
    const CH_NAME_STORAGE_CONDITIONS = "Условия хранения";

    const CH_GROUP_DESCRIPTION = "Описание товара";
    const CH_GROUP_COMPATIBILITY_WOOD = "Совместимость с породой дерева (максимальная оценка - 5 баллов)";
    const CH_GROUP_SUITABILITY_PARQUET = "Пригодность для типов паркета (максимальная оценка - 5 баллов)";
    const CH_GROUP_SUITABILITY_PLACEMENT = "Пригодность для типов помещений (максимальная оценка - 5 баллов)";
    const CH_GROUP_EXPLOITATION = "Эксплуатационные характеристики (максимальная оценка - 5 баллов)";
    const CH_GROUP_STORAGE = "Хранение";

    const CH_RATE = [
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

    const CHARACTERISTICS = [
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "boolean",
        "is_with_variations" => "boolean",
        "coefficient_description_show" => "boolean",
    ];

    public static function rbProductSlug($value, Route $route)
    {
        /** @var Category $category */
        $category = $route->category_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory1 */
        $subcategory1 = $route->subcategory1_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory2 */
        $subcategory2 = $route->subcategory2_slug;
        /** @var Category|null $subcategory3 */
        $subcategory3 = $route->subcategory3_slug;
        return static::query()
            ->where(static::TABLE . ".slug", $value)
            ->where(function(Builder $builder) use($category, $subcategory1, $subcategory2, $subcategory3) {
                return $builder
                        ->orWhere(static::TABLE . ".category_id", $category->id)
                        ->when($subcategory3->id ?? null, function(Builder $b, $sub3Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub3Id);
                        })
                        ->when($subcategory2->id ?? null, function(Builder $b, $sub2Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub2Id);
                        })
                        ->when($subcategory1->id ?? null, function(Builder $b, $sub1Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub1Id);
                        })
                ;
            })
            ->firstOrFail()
        ;
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;

        $this->addMediaCollection(static::MC_ADDITIONAL_IMAGES);

        $this->addMediaCollection(static::MC_FILES);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(static::MCONV_XS_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_XS_THUMB_SIZE,
                static::MCONV_XS_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonQueued()
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_SM_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_SM_THUMB_SIZE,
                static::MCONV_SM_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonQueued()
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_MD_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_MD_THUMB_SIZE,
                static::MCONV_MD_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonQueued()
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_LG_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_LG_THUMB_SIZE,
                static::MCONV_LG_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonQueued()
            ->nonOptimized()
        ;
    }

    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }


    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }

    public function scopeAvailable(Builder $builder): Builder
    {
        return $builder->whereIn(static::TABLE . ".availability_status_id", [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
    }

    public function getPriceRetailCurrencyNameAttribute(): ?string
    {
        return Currency::getFormattedName($this->price_retail_currency_id);
    }

    public function getIsVariationAttribute(): bool
    {
        return $this->parent_id !== null;
    }

    public function getIsAvailableAttribute(): bool
    {
        return in_array($this->availability_status_id, [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
    }

    public function getIsAvailableInStockAttribute(): bool
    {
        return $this->availability_status_id === AvailabilityStatus::ID_AVAILABLE_IN_STOCK;
    }

    public function getAvailableSubmitLabelAttribute(): string
    {
        switch ($this->availability_status_id) {
            case AvailabilityStatus::ID_AVAILABLE_IN_STOCK : {
                return "В корзину";
            }
            case AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK : {
                return "На заказ";
            }
            default : {
                return "Нет в наличии";
            }
        }
    }

    public function getIsAvailableNotInStockAttribute(): bool
    {
        return $this->availability_status_id === AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK;
    }

    public function getAvailabilityStatusNameAttribute(): string
    {
        switch ($this->availability_status_id) {
            case AvailabilityStatus::ID_AVAILABLE_IN_STOCK : {
                return "Есть в наличии";
                break;
            }
            case AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK : {
                return "Товар на заказ";
                break;
            }
            default : {
                return "Нет в наличии";
                break;
            }
        }
    }

    public function getPriceRetailRubAttribute(): ?float
    {
        return H::priceRub($this->price_retail, $this->price_retail_currency_id ?? $this->parent->price_retail_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPriceRetailRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_retail, $this->price_retail_currency_id ?? $this->parent->price_retail_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPricePurchaseRubAttribute(): ?float
    {
        return H::priceRub($this->price_purchase, $this->price_purchase_currency_id ?? $this->parent->price_purchase_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPricePurchaseRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_purchase, $this->price_purchase_currency_id ?? $this->parent->price_purchase_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getCoefficientPriceRubAttribute(): ?float
    {
        if (!$this->coefficient) return null;

        $priceRetailRub = $this->price_retail_rub;
        if (!$priceRetailRub) return null;

        return $priceRetailRub / $this->coefficient;
    }

    public function getCoefficientPriceRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->coefficient_price_rub, Currency::ID_RUB);
    }

    public function getMarginRubAttribute(): ?float
    {
        $retailRub = $this->price_retail_rub;
        $purchaseRub = $this->price_purchase_rub;

        return $retailRub - $purchaseRub;
    }

    public function getMarginRubFormattedAttribute(): string
    {
        $margin = $this->margin_rub;

        return H::priceRubFormatted($margin, Currency::ID_RUB);
    }

    public function getPriceMarkupAttribute(): ?float
    {
        $margin = $this->margin_rub;
        $purchaseRub = $this->price_purchase_rub;

        if (!$margin || !$purchaseRub) return null;

        return round($margin * 100 / $purchaseRub, 2);
    }

    public function getPriceIncomeAttribute(): ?float
    {
        $margin = $this->margin_rub;
        $retailRub = $this->price_retail_rub;

        if (!$margin || !$retailRub) return null;

        return round($margin * 100 / $retailRub, 2);
    }

    public function getIsInCartAttribute(): ?bool
    {
        /** @var \Domain\Users\Models\User\User|null $user */
        $user = Auth::user();
        if (!$user) return null;

        return in_array($this->id, $user->cart_not_trashed->pluck("id")->toArray());
    }

    public function scopeNotVariations(Builder $builder): Builder
    {
        return $builder->whereNull(static::TABLE . ".parent_id");
    }

    public function scopeVariations(Builder $builder): Builder
    {
        return $builder->whereNotNull(static::TABLE . ".parent_id");
    }

    /**
     * @param Builder|static $builder
     * @return Builder
     * */
    public function scopeDoesntHaveVariations(Builder $builder): Builder
    {
        return $builder->doesntHave("variations");
    }

    public function getRoute(): string
    {
        if ($this->is_variation) return $this->parent->getRoute();

        $category = $this->category;

        if ($category === null) return "";

        $parent1 = $category->parentCategory;
        if ($parent1 === null) return route("product.show.1", [$category->slug, $this->slug]);

        $parent2 = $parent1->parentCategory;
        if ($parent2 === null) return route("product.show.2", [$parent1->slug, $category->slug, $this->slug]);

        $parent3 = $parent2->parentCategory;
        if ($parent3 === null) return route("product.show.3", [$parent2->slug, $parent1->slug, $category->slug, $this->slug]);

        return route("product.show.4", [$parent3->slug, $parent2->slug, $parent1->slug, $category->slug, $this->slug]);
    }

    public function getWebRouteAttribute()
    {
        return $this->getRoute();
    }

    public function characteristics(): array
    {
        $result = [];

        foreach (static::CHARACTERISTICS as $groupName => $labelsColumns) {
            $labelsValues = [];
            foreach ($labelsColumns as $label => $column) {
                $labelsValues[$label] = $this->{$column};
            }
            $result[$groupName] = $labelsValues;
        }

        return $result;
    }

    public function characteristicsNotEmpty(): bool
    {
        $characteristics = $this->characteristics();
        foreach ($characteristics as $groupName => $labelsValues) {
            foreach ($labelsValues as $label => $value) {
                if (!empty($value)) return true;
            }
        }
        return false;
    }

    public function getMainImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE);
    }

    public function getMainImageXsThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_XS_THUMB);
    }

    public function getMainImageSmThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_SM_THUMB);
    }

    public function getMainImageMdThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_MD_THUMB);
    }

    public function getMainImageLgThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_LG_THUMB);
    }

    /**
     * @return string[]
     * */
    public function getImagesUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn(Media $media) => $media->getFullUrl())->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesXsThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn(Media $media) => $media->getFullUrl(static::MCONV_XS_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesSmThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn(Media $media) => $media->getFullUrl(static::MCONV_SM_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesMdThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn(Media $media) => $media->getFullUrl(static::MCONV_MD_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesLgThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn(Media $media) => $media->getFullUrl(static::MCONV_LG_THUMB))->toArray();
    }

    public function getOrderProductCountAttribute(): ?int
    {
        return $this->order_product === null
                ? null
                : $this->order_product->count
        ;
    }

    public function getOrderProductPriceRetailRubAttribute(): ?float
    {
        return $this->order_product === null
                ? null
                : H::priceRub($this->order_product->price_retail, $this->order_product->price_retail_currency_id ?? Product::DEFAULT_CURRENCY_ID)
        ;
    }

    public function getOrderProductPriceRetailRubFormattedAttribute(): ?string
    {
        return $this->order_product === null
                ? null
                : H::priceRubFormatted($this->order_product->price_retail, $this->order_product->price_retail_currency_id ?? Product::DEFAULT_CURRENCY_ID)
        ;
    }

    public function getOrderProductPriceRetailRubSumAttribute(): ?float
    {
        return $this->order_product === null
                ? null
                : $this->order_product_count * $this->order_product_price_retail_rub
        ;
    }

    public function getOrderProductPriceRetailRubSumFormattedAttribute(): ?string
    {
        return $this->order_product === null
            ? null
            : H::priceRubFormatted($this->order_product->price_retail * $this->order_product->count, $this->order_product->price_retail_currency_id ?? Product::DEFAULT_CURRENCY_ID)
        ;
    }
}
