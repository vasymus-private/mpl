<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Collections\ProductCollection;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Domain\Common\Models\BaseModel;
use Domain\Products\Models\Category;
use Domain\Common\Models\Currency;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Users\Models\Pivots\ProductUserCart;
use Domain\Users\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
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
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property OrderProduct|null $order_product
 *
 * @see \Domain\Users\Models\User\User::cart()
 * @property ProductUserCart|null $cart_product
 *
 * @see \Domain\Users\Models\User\User::viewed()
 * @property \Domain\Users\Models\Pivots\ProductUserViewed|null $viewed_product
 *
 * @see \Domain\Users\Models\User\User::aside()
 * @property \Domain\Users\Models\Pivots\ProductUserAside|null $aside_product
 *
 * @mixin \Domain\Products\Models\Product\ProductRelations
 * @mixin \Domain\Products\Models\Product\ProductAcM
 *
 * @method static static|\Domain\Products\QueryBuilders\ProductQueryBuilder query()
 **/
class Product extends BaseModel implements HasMedia
{
    use ProductRelations;
    use SoftDeletes;
    use InteractsWithMedia;
    use ProductAcM;

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

    public static function rbAdminProduct($value)
    {
        return static::query()->findOrFail($value);
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return static|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
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
}
