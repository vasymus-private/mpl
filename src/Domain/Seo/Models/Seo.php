<?php

namespace Domain\Seo\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property int|null $seoable_id
 * @property string|null $seoable_type
 *
 * @see \Domain\Seo\Models\Seo::getIsNotEmptyAttribute()
 * @property bool $is_not_empty
 * */
class Seo extends BaseModel
{
    public const TABLE = "seo";

    public const ID_APP = 1;

    public const TYPE_APP = 'app';
    public const TYPE_PRODUCT = 'product';
    public const TYPE_CATEGORY = 'category';

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
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "title",
        "h1",
        "keywords",
        "description",
    ];

    public static function appSeo(): self
    {
        return static::query()->findOrFail(static::ID_APP);
    }

    public function getIsNotEmptyAttribute(): bool
    {
        return $this->title && $this->keywords && $this->description;
    }
}
