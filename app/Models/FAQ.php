<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property int $id
 * @property string $question
 * @property string|null $answer
 * @property bool $is_active
 * @property string|null $user_name
 * @property string|null $user_email
 * @property Carbon $created_at
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
}
