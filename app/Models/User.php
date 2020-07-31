<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// if will use HasMediaTrait do not forget to call parent::registerMediaCollections() in Admin
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property int $status
 * @property string|null $password
 * @property string|null $remember_token
 *
 * @property string|null $anonymous_uid
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @property Carbon|null $email_verified_at
 *
 * Properties from Accessors / Mutators
 * @see User::getIsAdminAttribute()
 * @property bool $isAdmin
 *
 * @see User::getIsSuperAdminAttribute()
 * @property bool $isSuperAdmin
 *
 * @see User::getIsAnonymousAttribute()
 * @property bool $isAnonymous
 *
 * @mixin BaseModel
 * */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use CommonTraits;

    const TABLE = "users";

    const ADMIN_THRESHOLD = 5;
    const SUPER_ADMIN = 10;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = "mysql";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
    ];

    public static function mergeUidUser(self $uidUser = null, self $user)
    {
        // TODO implement
    }

    public static function firstOrCreateAnonymous(string $anonymousUid): self
    {
        return static::unguarded(function() use($anonymousUid) {
            return static::firstOrCreate([
                "anonymous_uid" => $anonymousUid,
            ]);
        });
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->status >= static::ADMIN_THRESHOLD;
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->status >= static::SUPER_ADMIN;
    }

    public function getIsAnonymousAttribute(): bool
    {
        return $this->email === null && (bool) $this->anonymous_uid;
    }
}
