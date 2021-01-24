<?php

namespace Domain\GalleryItems\Models;

use Domain\Seo\Models\Seo;
use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 *
 * @see GalleryItem::scopeParents()
 * @method static static|Builder parents()
 *
 * @see GalleryItem::child()
 * @property Collection|GalleryItem[] $child
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
        return $this->morphOne(\Domain\Seo\Models\Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;
    }

    public function child()
    {
        return $this->hasMany(GalleryItem::class, "parent_id", "id")->orderBy(GalleryItem::TABLE . ".ordering");
    }

    public function scopeParents(Builder $builder): Builder
    {
        return $builder->whereNull(static::TABLE . ".parent_id");
    }

    public static function rbParentGalleryItemSlug($value)
    {
        return static
            ::parents()
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail()
        ;
    }
}
