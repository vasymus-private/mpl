<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @see Category::parent()
 * @property Category|null $parent
 *
 * @see Category::subcategories()
 * @property Collection|Category[] $subcategories
 *
 * @see Category::seo()
 * @property Seo|null $seo
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

    public function parent(): BelongsTo
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
}
