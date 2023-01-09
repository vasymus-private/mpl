<?php

namespace Domain\Ip\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property string $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $country_a2
 * @property string|null $country_name
 * @property string|null $country_img
 * @property string|null $city
 * @property array $meta
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
}
