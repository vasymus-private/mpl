<?php

namespace Domain\Products\Models\Product;

use Domain\Common\Models\HasDeletedItemSlug;
use Domain\Products\Collections\ProductCollection;
use Domain\Products\DTOs\Web\CharCategoryDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\CharCategory;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Domain\Common\Models\BaseModel;
use Domain\Products\Models\Category;
use Domain\Common\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property bool $is_with_variations
 * @property int $category_id
 * @property int|null $ordering
 * @property bool $is_active
 * @property int|null $brand_id
 * @property string|null $coefficient
 * @property string|null $coefficient_description
 * @property bool $coefficient_description_show
 * @property string|null $price_name
 * @property string|null $admin_comment
 * @property string|null $price_purchase
 * @property int|null $price_purchase_currency_id
 * @property string|null $unit
 * @property string|null $price_retail
 * @property int|null $price_retail_currency_id
 * @property int $availability_status_id
 * @property string|null $preview
 * @property string|null $description
 *
 * @property string $accessory_name
 * @property string $similar_name
 * @property string $related_name
 * @property string $work_name
 * @property string $instruments_name
 *
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property array $meta
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property \Domain\Orders\Models\Pivots\OrderProduct|null $order_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::cart()
 * @property \Domain\Users\Models\Pivots\ProductUserCart|null $cart_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::viewed()
 * @property \Domain\Users\Models\Pivots\ProductUserViewed|null $viewed_product
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::aside()
 * @property \Domain\Users\Models\Pivots\ProductUserAside|null $aside_product
 *
 * @mixin \Domain\Products\Models\Product\ProductRelations
 * @mixin \Domain\Products\Models\Product\ProductAcM
 * @mixin \Domain\Common\Models\HasDeletedItemSlug
 *
 * @method static static|\Domain\Products\QueryBuilders\ProductQueryBuilder query()
 **/
class Product extends BaseModel implements HasMedia
{
    use ProductRelations;
    use SoftDeletes;
    use InteractsWithMedia;
    use ProductAcM;
    use HasDeletedItemSlug;

    const DEFAULT_IS_ACTIVE = false;
    const DEFAULT_IS_WITH_VARIATIONS = false;
    const DEFAULT_COEFFICIENT_DESCRIPTION_SHOW = false;
    const DEFAULT_PRICE_NAME = 'Цена';
    const DEFAULT_AVAILABILITY_STATUS_ID = AvailabilityStatus::ID_NOT_AVAILABLE;
    const DEFAULT_ACCESSORY_NAME = 'Аксессуары';
    const DEFAULT_SIMILAR_NAME = 'Похожие';
    const DEFAULT_RELATED_NAME = 'Сопряженные';
    const DEFAULT_WORK_NAME = 'Работы';
    const DEFAULT_INSTRUMENTS_NAME = 'Инструменты';
    const DEFAULT_CURRENCY_ID = Currency::ID_RUB;
    const DEFAULT_ORDERING = 500;

    const TABLE = "products";

    const MAX_CHARACTERISTIC_RATE = 5;

    const MC_MAIN_IMAGE = "main";
    const MC_ADDITIONAL_IMAGES = "images";
    const MC_FILES = "files";

    const MCONV_XS_THUMB = "xs-thumb"; // 40x40
    const MCONV_XS_THUMB_SIZE = 40;
    const MCONV_SM_THUMB = "sm-thumb"; // 50x50
    const MCONV_SM_THUMB_SIZE = 50;
    const MCONV_MD_THUMB = "md-thumb"; // 120x120
    const MCONV_MD_THUMB_SIZE = 120;
    const MCONV_LG_THUMB = "lg-thumb"; // 220x220
    const MCONV_LG_THUMB_SIZE = 220;
    const MCONV_FILL_BG = "ffffff";

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
        'is_with_variations' => self::DEFAULT_IS_WITH_VARIATIONS,
        'coefficient_description_show' => self::DEFAULT_COEFFICIENT_DESCRIPTION_SHOW,
        'price_name' => self::DEFAULT_PRICE_NAME,
        'availability_status_id' => self::DEFAULT_AVAILABILITY_STATUS_ID,
        'accessory_name' => self::DEFAULT_ACCESSORY_NAME,
        'similar_name' => self::DEFAULT_SIMILAR_NAME,
        'related_name' => self::DEFAULT_RELATED_NAME,
        'work_name' => self::DEFAULT_WORK_NAME,
        'instruments_name' => self::DEFAULT_INSTRUMENTS_NAME,
        'ordering' => self::DEFAULT_ORDERING,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "boolean",
        "is_with_variations" => "boolean",
        "coefficient_description_show" => "boolean",
        'meta' => 'array',
    ];

    public static function rbProductSlug($value, Route $route)
    {
        /** @var Category $category */
        $category = $route->category_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory1 */
        $subcategory1 = $route->subcategory1_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory2 */
        $subcategory2 = $route->subcategory2_slug;
        /** @var Category|null $subcategory3 */
        $subcategory3 = $route->subcategory3_slug;
        return static::query()
            ->where(static::TABLE . ".slug", $value)
            ->where(function(Builder $builder) use($category, $subcategory1, $subcategory2, $subcategory3) {
                return $builder
                        ->orWhere(static::TABLE . ".category_id", $category->id)
                        ->when($subcategory3->id ?? null, function(Builder $b, $sub3Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub3Id);
                        })
                        ->when($subcategory2->id ?? null, function(Builder $b, $sub2Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub2Id);
                        })
                        ->when($subcategory1->id ?? null, function(Builder $b, $sub1Id) {
                            return $b->orWhere(static::TABLE . ".category_id", $sub1Id);
                        })
                ;
            })
            ->firstOrFail()
        ;
    }

    public static function rbAdminProduct($value)
    {
        return static::query()->select(["*"])->notVariations()->findOrFail($value);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;

        $this->addMediaCollection(static::MC_ADDITIONAL_IMAGES);

        $this->addMediaCollection(static::MC_FILES);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(static::MCONV_XS_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_XS_THUMB_SIZE,
                static::MCONV_XS_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_SM_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_SM_THUMB_SIZE,
                static::MCONV_SM_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_MD_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_MD_THUMB_SIZE,
                static::MCONV_MD_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;

        $this->addMediaConversion(static::MCONV_LG_THUMB)
            ->fit(
                Manipulations::FIT_FILL,
                static::MCONV_LG_THUMB_SIZE,
                static::MCONV_LG_THUMB_SIZE
            )
            ->background(static::MCONV_FILL_BG)
            ->performOnCollections(static::MC_MAIN_IMAGE, static::MC_ADDITIONAL_IMAGES)
            ->nonOptimized()
        ;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return static|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    /**
     * @return \Domain\Products\DTOs\Web\CharCategoryDTO[]
     */
    public function characteristics2(): array
    {
        return Cache
            ::store('array')
            ->rememberForever(
                sprintf('%s-characteristis-%s', static::class, $this->id),
                fn() => $this->charCategories->map(fn(CharCategory $charCategory) => CharCategoryDTO::fromModel($charCategory))->all()
            );
    }

    public function characteristicsIsEmpty(): bool
    {
        $characteristics = $this->characteristics2();

        foreach ($characteristics as $charCategory) {
            foreach ($charCategory->chars as $char) {
                if (!$char->is_empty) return false;
            }
        }

        return true;
    }
}
