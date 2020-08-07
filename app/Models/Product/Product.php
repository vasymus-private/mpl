<?php

namespace App\Models\Product;

use App\H;
use App\Models\AvailabilityStatus;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Currency;
use App\Services\CBRcurrencyConverter\CBRcurrencyConverter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

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
 * @see Product::scopeActive()
 * @method static static|Builder active()
 *
 * @see Product::getPriceRetailCurrencyNameAttribute()
 * @property string|null $price_retail_currency_name
 *
 * @see Product::getIsAvailableAttribute()
 * @property bool $is_available
 *
 * @see Product::getAvailabilityStatusNameAttribute()
 * @property string $availability_status_name
 *
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
 **/
class Product extends BaseModel implements HasMedia
{
    use ProductRelations;
    use SoftDeletes;
    use HasMediaTrait;

    const TABLE = "products";
    const MAX_CHARACTERISTIC_RATE = 5;

    const MC_MAIN_IMAGE = "main";
    const MC_ADDITIONAL_IMAGES = "images";
    const MC_FILES = "files";

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
    ];

    public static function rbProductSlug($value, Route $route)
    {
        /** @var Category $category */
        $category = $route->category_slug;
        /** @var Category|null $subcategory1 */
        $subcategory1 = $route->subcategory1_slug;
        /** @var Category|null $subcategory2 */
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

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;

        $this->addMediaCollection(static::MC_ADDITIONAL_IMAGES);

        $this->addMediaCollection(static::MC_FILES);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }

    public function getPriceRetailCurrencyNameAttribute(): ?string
    {
        return Currency::getFormattedName($this->price_retail_currency_id);
    }

    public function getIsAvailableAttribute(): bool
    {
        return in_array($this->availability_status_id, [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
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
        return H::priceRub($this->price_retail, $this->price_retail_currency_id);
    }

    public function getPriceRetailRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_retail, $this->price_retail_currency_id);
    }

    public function getPricePurchaseRubAttribute(): ?float
    {
        return H::priceRub($this->price_purchase, $this->price_purchase_currency_id);
    }

    public function getPricePurchaseRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_purchase, $this->price_purchase_currency_id);
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
}
