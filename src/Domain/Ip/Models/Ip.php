<?php

namespace Domain\Ip\Models;

use Domain\Common\Models\BaseModel;
use Domain\Users\Models\Blacklist;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $country_a2
 * @property string|null $country_name
 * @property string|null $country_img
 * @property string|null $city
 * @property array $meta
 *
 * @property int|null $blacklist_count
 *
 * @see \Domain\Ip\Models\Ip::getInBlacklistAttribute()
 * @property bool $in_blacklist
 * */
class Ip extends BaseModel
{
    public const TABLE = "ips";

    public const UPDATED_AT = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ip';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'meta' => '[]',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blacklist(): HasMany
    {
        return $this->hasMany(Blacklist::class, 'ip', 'ip');
    }

    /**
     * @return bool
     */
    public function getInBlacklistAttribute(): bool
    {
        return $this->blacklist_count !== null && $this->blacklist_count > 0;
    }
}
