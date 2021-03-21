<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
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
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @see \Domain\Products\Models\Category::parentCategory()
 * @property \Domain\Products\Models\Category|null $parentCategory
 *
 * @see \Domain\Products\Models\Category::subcategories()
 * @property Collection|\Domain\Products\Models\Category[] $subcategories
 *
 * @see \Domain\Products\Models\Category::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 *
 * @see \Domain\Products\Models\Category::scopeParents()
 * @method static static|\Illuminate\Database\Eloquent\Builder parents()
 *
 * @see \Domain\Products\Models\Category::scopeActive()
 * @method static static|\Illuminate\Database\Eloquent\Builder active()
 *
 * @see \Domain\Products\Models\Category::scopeOrdering()
 * @method static static|\Illuminate\Database\Eloquent\Builder ordering()
 *
 * @see \Domain\Products\Models\Category::getAllLoadedSubcategoriesIdsAttribute()
 * @property-read int[] $all_loaded_subcategories_ids
 * */
class Category extends BaseModel
{
    use SoftDeletes;

    const TABLE = "categories";

    // TODO temporary decision for menu render
    const _TEMP_ID_PARKET = 1;
    const _TEMP_ID_PARKET_GLUE = 8;
    const _TEMP_ID_PARKET_LACQUER = 19;
    const _TEMP_ID_PARKET_OIL = 31;
    const _TEMP_ID_PUTTY = 36;
    const _TEMP_ID_CARE_TOOLS = 39;
    const _TEMP_ID_FLOOR_BASE = 46;
    const _TEMP_ID_EQUIPMENT = 54;
    const _TEMP_ID_RELATED_TOOLS = 60;

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
        return $this->hasMany(Category::class, "parent_id", "id")->orderBy(Category::TABLE . ".ordering");
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

    public static function getSidebarDividerCount(Category $category): int
    {
        switch ($category->id) {
            case static::_TEMP_ID_PARKET :
            case static::_TEMP_ID_PARKET_GLUE :
            case static::_TEMP_ID_CARE_TOOLS :
            case static::_TEMP_ID_FLOOR_BASE : {
                return 3;
            }
            case static::_TEMP_ID_PARKET_LACQUER :
            case static::_TEMP_ID_PARKET_OIL :
            case static::_TEMP_ID_PUTTY: {
                return 2;
            }
            case static::_TEMP_ID_EQUIPMENT :
            case static::_TEMP_ID_RELATED_TOOLS : {
                return 1;
            }
            default : {
                return $category->subcategories->count() / 2;
            }
        }
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }

    public function scopeOrdering(Builder $builder): Builder
    {
        return $builder->orderBy(static::TABLE . ".ordering");
    }

    /**
     * @return int[]
     */
    public function getAllLoadedSubcategoriesIdsAttribute(): array
    {
        return $this->allLoadedSubcategoriesIds($this);
    }

    /**
     * @param \Domain\Products\Models\Category $category
     *
     * @return int[]
     */
    public function allLoadedSubcategoriesIds(Category $category): array
    {
        $subcategoriesIds = $category->subcategories->pluck("id")->toArray();
        foreach ($category->subcategories as $subcategory) {
            if ($subcategory->relationLoaded("subcategories")) {
                $subcategoriesIds = array_merge($subcategoriesIds, $this->allLoadedSubcategoriesIds($subcategory));
            }
        }
        return $subcategoriesIds;
    }
}