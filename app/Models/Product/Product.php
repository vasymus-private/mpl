<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property int|null $manufacturer_id
 * @property string|null $coefficient
 * @property string|null $coefficient_description
 * @property string|null $price_name
 * @property string|null $admin_comment
 * @property string|null $price_purchase
 * @property int|null $price_purchase_currency_id
 * @property string|null $unit
 * @property string|null $price_retail
 * @property int|null $price_retail_currency_id
 * @property bool $is_in_stock
 * @property bool $is_available
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @mixin ProductRelations
 **/
class Product extends BaseModel
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
        "is_in_stock" => "boolean",
        "is_available" => "boolean",
    ];

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;

        $this->addMediaCollection(static::MC_ADDITIONAL_IMAGES);

        $this->addMediaCollection(static::MC_FILES);
    }
}
