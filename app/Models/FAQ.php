<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string $question
 * @property string|null $answer
 * @property int|null $parent_id
 * @property bool $is_active
 * @property string|null $user_name
 * @property string|null $user_email
 * @property Carbon $created_at
 *
 * @property Seo|null $seo
 *
 * @see FAQ::scopeParents()
 * @method static static|Builder parents()
 * */
class FAQ extends BaseModel implements HasMedia
{
    use HasMediaTrait;

    const TABLE = "faq";
    const UPDATED_AT = null;

    const MC_FILES = "files";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "bool",
    ];

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(static::MC_FILES);
    }

    public function scopeParents(Builder $builder): Builder
    {
        return $builder->whereNull(static::TABLE . ".parent_id");
    }
}
