<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
use Domain\Products\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $preview
 * @property string|null $description
 * @property Carbon|null $deleted_at
 * */
class Brand extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    const TABLE = "brands";

    const MC_MAIN_IMAGE = "main";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function rbBrandSlug($value)
    {
        return Brand::query()->where(Brand::TABLE . ".slug", $value)->firstOrFail();
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "brand_id", "id");
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;
    }
}
