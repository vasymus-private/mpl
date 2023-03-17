<?php

namespace Domain\Products\Models;

use Database\Factories\CategoryFactory;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\BaseModel;
use Domain\Common\Models\HasDeletedItemSlug;
use Domain\Products\Actions\HasActiveProductsAction;
use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\CategoryQueryBuilder;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $slug
 * @property int|null $parent_id
 * @property int $ordering
 * @property bool $is_active
 * @property int $product_type
 * @property string|null $description
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property array $meta
 *
 * @see \Domain\Products\Models\Category::parentCategory()
 * @property \Domain\Products\Models\Category|null $parentCategory
 *
 * @see \Domain\Products\Models\Category::subcategories()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[] $subcategories
 *
 * @see \Domain\Products\Models\Category::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 *
 * @see \Domain\Products\Models\Category::products()
 * @property \Domain\Products\Collections\ProductCollection|\Domain\Products\Models\Product\Product[] $products
 *
 * @see \Domain\Products\Models\Category::getAllLoadedSubcategoriesIdsAttribute()
 * @property-read int[] $all_loaded_subcategories_ids
 *
 * @see \Domain\Products\Models\Category::getHasActiveProductsAttribute()
 * @property-read bool $has_active_products
 *
 * @method static \Domain\Products\QueryBuilders\CategoryQueryBuilder query()
 * */
class Category extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use HasDeletedItemSlug;
    use HasFactory;
    use InteractsWithMedia;

    public const TABLE = "categories";

    // TODO temporary decision for menu render
    public const _TEMP_ID_PARKET = 1;
    public const _TEMP_ID_PARKET_GLUE = 8;
    public const _TEMP_ID_PARKET_LACQUER = 19;
    public const _TEMP_ID_PARKET_OIL = 31;
    public const _TEMP_ID_PUTTY = 36;
    public const _TEMP_ID_CARE_TOOLS = 39;
    public const _TEMP_ID_FLOOR_BASE = 46;
    public const _TEMP_ID_EQUIPMENT = 54;
    public const _TEMP_ID_RELATED_TOOLS = 60;

    public const PRODUCT_TYPE_PARQUET_MATERIALS = 1;
    public const PRODUCT_TYPE_PARQUET_WORKS = 2;

    public const DEFAULT_IS_ACTIVE = true;
    public const DEFAULT_ORDERING = 500;
    public const DEFAULT_PRODUCT_TYPE = self::PRODUCT_TYPE_PARQUET_MATERIALS;

    public const MC_DESCRIPTION_FILES = 'description-files';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => self::DEFAULT_IS_ACTIVE,
        'ordering' => self::DEFAULT_ORDERING,
        'product_type' => self::DEFAULT_PRODUCT_TYPE,
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "boolean",
        'meta' => 'array',
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

    public static function rbAdminCategory($value)
    {
        return static::query()->select(["*"])->findOrFail($value);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    /**
     * @inheritDoc
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! $this->uuid) {
            $this->uuid = (string) Str::uuid();
        }
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        /** @var \Domain\Products\QueryBuilders\ProductQueryBuilder $productsQuery */
        $productsQuery = $this->hasMany(Product::class, 'category_id', 'id');

        /** @var \Illuminate\Database\Eloquent\Relations\HasMany $result */
        $result = $productsQuery->notVariations();

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key, \Domain\Products\Models\Category>
     */
    public static function getTreeRuntimeCached(): Collection
    {
        return Cache::store('array')->rememberForever('categories', function () {
            return Category::query()->parents()->with("subcategories.subcategories.subcategories")->orderBy(Category::TABLE . ".ordering")->get();
        });
    }

    public static function rbCategorySlug($value)
    {
        return static::query()->where(static::TABLE . ".slug", $value)->firstOrFail();
    }

    public static function rbSubcategory1Slug($value, Route $route)
    {
        /** @var Category $parentCategory */
        $parentCategory = $route->category_slug; // @phpstan-ignore-line

        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }

    public static function rbSubcategory2Slug($value, Route $route)
    {
        /** @var Category $parentCategory */
        $parentCategory = $route->subcategory1_slug; // @phpstan-ignore-line

        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }

    public static function rbSubcategory3Slug($value, Route $route)
    {
        /** @var Category $parentCategory */
        $parentCategory = $route->subcategory2_slug; // @phpstan-ignore-line

        return static::query()->where(static::TABLE . ".slug", $value)->where(static::TABLE . ".parent_id", $parentCategory->id)->firstOrFail();
    }

    public static function getSidebarDividerCount(Category $category): int
    {
        switch ($category->id) {
            case static::_TEMP_ID_PARKET:
            case static::_TEMP_ID_PARKET_GLUE:
            case static::_TEMP_ID_CARE_TOOLS:
            case static::_TEMP_ID_FLOOR_BASE: {
                return 3;
            }
            case static::_TEMP_ID_PARKET_LACQUER:
            case static::_TEMP_ID_PARKET_OIL:
            case static::_TEMP_ID_PUTTY: {
                return 2;
            }
            case static::_TEMP_ID_EQUIPMENT:
            case static::_TEMP_ID_RELATED_TOOLS: {
                return 1;
            }
            default: {
                return $category->subcategories->count() / 2;
            }
        }
    }

    /**
     * @return \Domain\Common\DTOs\OptionDTO[]
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function getProductTypeOptions(): array
    {
        return [
            new OptionDTO([
                'value' => static::PRODUCT_TYPE_PARQUET_MATERIALS,
                'label' => 'Паркетные материалы',
            ]),
            new OptionDTO([
                'value' => static::PRODUCT_TYPE_PARQUET_WORKS,
                'label' => 'Паркетные работы',
            ]),
        ];
    }

    /**
     * @return int[]
     */
    public static function getProductTypes(): array
    {
        return [
            static::PRODUCT_TYPE_PARQUET_MATERIALS,
            static::PRODUCT_TYPE_PARQUET_WORKS,
        ];
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
    protected function allLoadedSubcategoriesIds(Category $category): array
    {
        $subcategoriesIds = $category->subcategories->pluck("id")->toArray();
        foreach ($category->subcategories as $subcategory) {
            if ($subcategory->relationLoaded("subcategories")) {
                $subcategoriesIds = array_merge($subcategoriesIds, $this->allLoadedSubcategoriesIds($subcategory));
            }
        }

        return $subcategoriesIds;
    }

    public function getHasActiveProductsAttribute(): bool
    {
        return HasActiveProductsAction::cached()->execute($this->id);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_DESCRIPTION_FILES);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Domain\Products\QueryBuilders\CategoryQueryBuilder<\Domain\Products\Models\Category>
     */
    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }
}
