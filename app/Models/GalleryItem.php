<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property int|null $ordering
 * @property int|null $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Seo|null $seo
 * */
class GalleryItem extends BaseModel implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;

    const TABLE = "gallery_items";

    const MC_MAIN_IMAGE = "main";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;
    }
}
