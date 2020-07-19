<?php

namespace App\Models;

use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * @property int $id
 * @property string $name
 * @property string|null $preview
 * @property string|null $description
 * @property Carbon|null $deleted_at
 * */
class Manufacturer extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    const TABLE = "manufacturers";

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

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "manufacturer_id", "id");
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;
    }
}
