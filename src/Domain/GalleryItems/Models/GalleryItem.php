<?php

namespace Domain\GalleryItems\Models;

use Carbon\Carbon;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\BaseModel;
use Domain\Common\Models\CustomMedia;
use Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Support\H;

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
 * @see \Domain\GalleryItems\Models\GalleryItem::parent()
 * @property \Domain\GalleryItems\Models\GalleryItem|null $parent
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::children()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\GalleryItems\Models\GalleryItem[] $children
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::getMainImageUrlAttribute()
 * @property-read string $main_image_url
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::getWebRouteAttribute()
 * @property-read string|null $web_route
 *
 * @see \Domain\GalleryItems\Models\GalleryItem::getMainImageMediaAttribute()
 * @property-read \Domain\Common\Models\CustomMedia|null $main_image_media
 *
 * @method static \Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder query()
 * */
class GalleryItem extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;

    public const TABLE = "gallery_items";

    public const DEFAULT_IS_ACTIVE = false;
    public const DEFAULT_ORDERING = 500;

    public const MC_MAIN_IMAGE = "main";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "bool",
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => self::DEFAULT_IS_ACTIVE,
        'ordering' => self::DEFAULT_ORDERING,
    ];

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
     * @return \Domain\Common\DTOs\OptionDTO[]
     */
    public static function getGalleryItemOption()
    {
        return Cache::store('array')->rememberForever('options-gallery-items', function () {
            return static::query()->select(["id", "name"])->get()->map(fn (GalleryItem $galleryItem) => OptionDTO::fromGalleryItem($galleryItem)->toArray())->all();
        });
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(GalleryItem::class, "parent_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany|\Domain\GalleryItems\QueryBuilders\GalleryItemQueryBuilder $hm */
        $hm = $this->hasMany(GalleryItem::class, "parent_id", "id");

        return $hm->active()->orderBy(GalleryItem::TABLE . ".ordering");
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

    /**
     * @return string|null
     */
    public function getWebRouteAttribute(): ?string
    {
        return Cache::store('array')->rememberForever(sprintf('gallery_item_web_route_%s', $this->id), function () {
            if (! $this->parent_id) {
                return null;
            }

            $parent = $this->parent;

            if (!$parent) {
                return null;
            }

            return route('gallery.items.show', [$parent->slug]);
        });
    }

    /**
     * @return \Domain\Common\Models\CustomMedia|null
     */
    public function getMainImageMediaAttribute(): ?CustomMedia
    {
        return H::runtimeCache(sprintf('%s-%s', 'gallery-item-main-image-media', $this->uuid), fn () => $this->getFirstMedia(static::MC_MAIN_IMAGE));
    }
}
