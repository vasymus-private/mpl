<?php

namespace Domain\Users\Models;

use Domain\Common\Models\BaseModel;
use Domain\Ip\Models\Ip;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string|null $ip
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @see \Domain\Users\Models\Blacklist::ipDetails()
 * @property \Domain\Ip\Models\Ip|null $ipDetails
 * */
class Blacklist extends BaseModel
{
    use SoftDeletes;

    public const TABLE = "blacklist";

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
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

    public static function rbAdminBlacklist($value)
    {
        return static::query()->findOrFail($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ipDetails(): BelongsTo
    {
        return $this->belongsTo(Ip::class, "ip", "ip");
    }
}
