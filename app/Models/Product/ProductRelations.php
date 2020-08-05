<?php

namespace App\Models\Product;

use App\Models\Category;
use App\Models\InformationalPrice;
use App\Models\Brand;
use App\Models\Pivots\ProductProduct;
use App\Models\Seo;
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
 * @see ProductRelations::works()
 * @property Collection|Product[] $works
 *
 * @see ProductRelations::category()
 * @property Category|null $category
 *
 * @see ProductRelations::infoPrices()
 * @property Collection|InformationalPrice[] $infoPrices
 *
 * @see ProductRelations::seo()
 * @property Seo|null $seo
 * */
trait ProductRelations
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, "parent_id", "id");
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Product::class, "parent_id", "id");
    }

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

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "manufacturer_id", "id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id", "id");
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
