<?php

namespace Domain\Users\Models;

use Domain\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string|null $ip
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * */
class Blacklist extends BaseModel
{
    use SoftDeletes;

    public const TABLE = "blacklist";

    public const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

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
}
