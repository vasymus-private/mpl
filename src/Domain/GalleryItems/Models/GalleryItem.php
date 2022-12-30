<?php

namespace Domain\GalleryItems\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property int|null $ordering
 * @property int|null $parent_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::children()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\GalleryItems\Models\GalleryItem[] $children
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::getMainImageUrlAttribute()
 * @property-read string $main_image_url
 *
 * @method static \Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder query()
 * */
class GalleryItem extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;

    public const TABLE = "gallery_items";

    public const MC_MAIN_IMAGE = "main";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        $cb = function (self $model) {
            if (! $model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        };

        static::saving($cb);
    }

    /**
     * @param $value
     *
     * @return \Domain\GalleryItems\Models\GalleryItem
     */
    public static function rbParentGalleryItemSlug($value)
    {
        return static::query()
            ->parents()
            ->active()
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail();
    }

    /**
     * @param $value
     *
     * @return \Domain\GalleryItems\Models\GalleryItem
     */
    public static function rbAdminGalleryItem($value)
    {
        return static::query()->findOrFail($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(GalleryItem::class, "parent_id", "id")->orderBy(GalleryItem::TABLE . ".ordering");
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder<\Domain\GalleryItems\Models\GalleryItem>
     */
    public function newEloquentBuilder($query): GalleryItemQueryBuilder
    {
        return new GalleryItemQueryBuilder($query);
    }

    /**
     * @return string
     */
    public function getMainImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE);
    }
}
