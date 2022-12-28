<?php

namespace Domain\Articles\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $parent_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see \Domain\Articles\Models\Article::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 *
 * @see \Domain\Articles\Models\Article::parent()
 * @property \Domain\Articles\Models\Article|null $parent
 *
 * @see \Domain\Articles\Models\Article::children()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\Articles\Models\Article[] $children
 *
 * @see \Domain\Articles\Models\Article::scopeActive()
 * @method static static|\Illuminate\Database\Eloquent\Builder active()
 * */
class Article extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public const TABLE = "articles";

    public const DEFAULT_IS_ACTIVE = false;

    public const MC_DESCRIPTION_FILES = "description-files";

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
        "is_active" => "boolean",
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => self::DEFAULT_IS_ACTIVE,
    ];

    public static function route(Article $article): string
    {
        return route(
            "articles.show",
            $article->parent_id === null
                ? [$article->slug]
                : [$article->slug, $article->parent->slug]
        );
    }

    public static function rbArticleSlug($value, Route $route)
    {
        return static::active()
            ->whereNull(static::TABLE . ".parent_id")
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail()
        ;
    }

    public static function rbSubArticleSlug($value, Route $route)
    {
        /** @var Article $parent */
        $parent = $route->article_slug; // @phpstan-ignore-line

        return static::active()
            ->where(static::TABLE . ".parent_id", $parent->id)
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail()
        ;
    }

    public static function rbAdminArticle($value)
    {
        return static::query()->findOrFail($value);
    }

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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Article::class, "parent_id", "id");
    }

    public function children()
    {
        return $this->hasMany(Article::class, "parent_id", "id");
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_DESCRIPTION_FILES);
    }
}
