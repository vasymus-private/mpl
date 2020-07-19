<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int $ordering
 * @property bool $is_active
 * @property string|null $description
 * @property Carbon|null $deleted_at
 *
 * @see Category::parentCategory()
 * @property Category|null $parentCategory
 *
 * @see Category::subcategories()
 * @property Collection|Category[] $subcategories
 *
 * @see Category::seo()
 * @property Seo|null $seo
 *
 * @see Category::scopeParents()
 * @method static static|Builder parents()
 * */
class Category extends BaseModel
{
    use SoftDeletes;

    const TABLE = "categories";

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "boolean",
    ];

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, "parent_id", "id");
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function scopeParents(Builder $builder): Builder
    {
        return $builder->whereNull(static::TABLE . ".parent_id");
    }

    public static function rbCategorySlug($value)
    {
        return static::query()->where(static::TABLE . ".slug", $value)->firstOrFail();
    }

    public static function rbSubcategory1Slug($value, Route $route)
    {
        /** @var Category $parentCategory*/
        $parentCategory = $route->category_slug;
        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }

    public static function rbSubcategory2Slug($value, Route $route)
    {
        /** @var Category $parentCategory*/
        $parentCategory = $route->subcategory1_slug;
        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }

    public static function rbSubcategory3Slug($value, Route $route)
    {
        /** @var Category $parentCategory*/
        $parentCategory = $route->subcategory2_slug;
        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }
}
