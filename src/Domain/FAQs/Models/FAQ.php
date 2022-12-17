<?php

namespace Domain\FAQs\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\FAQs\QueryBuilders\FaqQueryBuilder;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $uuid
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
 * @see FAQ::children()
 * @property Collection|FAQ[] $children
 *
 * @method static \Domain\FAQs\QueryBuilders\FaqQueryBuilder query()
 * */
class FAQ extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    public const TABLE = "faq";
    public const UPDATED_AT = null;

    public const MC_FILES = "files";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_active" => "bool",
    ];

    public static function rbFaqSlug($value)
    {
        return static::query()->parents()->active()->where(static::TABLE . ".slug", $value)->firstOrFail();
    }

    public static function rbAdminFaq($value)
    {
        return static::query()->findOrFail($value);
    }

    public static function faqOptions()
    {
        return static::query()->select(['id', 'uuid', 'name', 'parent_id', 'is_active'])->get();
    }

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

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_FILES);
    }

    public function children()
    {
        return $this->hasMany(FAQ::class, "parent_id", "id");
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Domain\FAQs\QueryBuilders\FaqQueryBuilder<\Domain\FAQs\Models\FAQ>
     */
    public function newEloquentBuilder($query): FaqQueryBuilder
    {
        return new FaqQueryBuilder($query);
    }
}
