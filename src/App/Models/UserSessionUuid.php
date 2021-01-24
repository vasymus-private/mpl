<?php

namespace App\Models;

use App\Models\User\User;
use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

/**
 * @property string $session_uuid
 * @property int $user_id
 * @property bool $via_credentials
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * */
class UserSessionUuid extends BaseModel
{
    const TABLE = "user_session_uuids";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'session_uuid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "via_credentials" => "boolean",
    ];

    public static function createBySessionUuid(User $user, UuidInterface $sessionUuid): self // TODO move to actions
    {
        return static::query()->forceCreate([
            "session_uuid" => $sessionUuid->toString(),
            "user_id" => $user->id,
        ]);
    }
}
