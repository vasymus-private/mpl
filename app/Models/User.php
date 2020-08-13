<?php

namespace App\Models;

use App\Models\Pivots\ProductUserAside;
use App\Models\Pivots\ProductUserCart;
use App\Models\Pivots\ProductUserViewed;
use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @see User::products()
 * @property Product[]|Collection $products
 *
 * @see User::cart()
 * @property Product[]|Collection $cart
 *
 * @see User::viewed()
 * @property Product[]|Collection $viewed
 *
 * @see User::aside()
 * @property Product[]|Collection $aside
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

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserCart::TABLE)->using(ProductUserCart::class)->withPivot(["count", "created_at", "deleted_at"])->withTimestamps();
    }

    public function viewed(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserViewed::TABLE)->using(ProductUserViewed::class)->withPivot(["created_at"])->withTimestamps();
    }

    public function aside(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserAside::TABLE)->using(ProductUserAside::class)->withPivot(["created_at"])->withTimestamps();
    }
}
