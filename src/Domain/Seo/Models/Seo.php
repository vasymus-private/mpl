<?php

namespace Domain\Seo\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property int $seoable_id
 * @property string $seoable_type
 * */
class Seo extends BaseModel
{
    const TABLE = "seo";

    const ID_APP = 1;

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
     * @var array
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
}
