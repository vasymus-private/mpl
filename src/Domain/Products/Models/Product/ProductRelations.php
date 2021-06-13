<?php

namespace Domain\Products\Models\Product;

use Domain\Products\Models\Category;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Pivots\CategoryProduct;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @see ProductRelations::parent()
 * @property Product|null $parent
 *
 * @see ProductRelations::variations()
 * @property Collection|Product[] $variations
 *
 * @see ProductRelations::accessory()
 * @property Collection|Product[] $accessory
 *
 * @see ProductRelations::similar()
 * @property Collection|Product[] $similar
 *
 * @see ProductRelations::related()
 * @property Collection|Product[] $related
 *
 * @see \Domain\Products\Models\Product\ProductRelations::instruments()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Product\Product[] $instruments
 *
 * @see ProductRelations::works()
 * @property Collection|Product[] $works
 *
 * @see ProductRelations::category()
 * @property Category|null $category
 *
 * @see \Domain\Products\Models\Product\ProductRelations::relatedCategories()
 * @property \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[] $relatedCategories
 *
 * @see ProductRelations::infoPrices()
 * @property Collection|\Domain\Products\Models\InformationalPrice[] $infoPrices
 *
 * @see ProductRelations::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 *
 * @see ProductRelations::brand()
 * @property Brand|null $brand
 * */
trait ProductRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, "parent_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function variations(): HasMany
    {
        return $this->hasMany(Product::class, "parent_id", "id")->orderBy(Product::TABLE . '.ordering', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function products(): BelongsToMany
    {
        /** @var BelongsToMany $bm */
        $bm = $this->belongsToMany(Product::class, ProductProduct::TABLE, "product_1_id", "product_2_id");
        return $bm
                ->using(ProductProduct::class)
                ->withPivot(["type"])
        ;
    }

    public function accessory(): BelongsToMany
    {
        return $this->products()->wherePivot("type", ProductProduct::TYPE_ACCESSORY);
    }

    public function similar(): BelongsToMany
    {
        return $this->products()->wherePivot("type", ProductProduct::TYPE_SIMILAR);
    }

    public function related(): BelongsToMany
    {
        return $this->products()->wherePivot("type", ProductProduct::TYPE_RELATED);
    }

    public function works(): BelongsToMany
    {
        return $this->products()->wherePivot("type", ProductProduct::TYPE_WORK);
    }

    public function instruments(): BelongsToMany
    {
        return $this->products()->wherePivot("type", ProductProduct::TYPE_INSTRUMENT);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "brand_id", "id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function relatedCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, CategoryProduct::TABLE, 'product_id', 'category_id')->using(CategoryProduct::class);
    }

    public function infoPrices(): HasMany
    {
        return $this->hasMany(InformationalPrice::class, "product_id", "id");
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }
}
