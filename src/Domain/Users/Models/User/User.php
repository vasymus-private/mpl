<?php

namespace Domain\Users\Models\User;

use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Builder;

class User extends BaseUser
{
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("user", function(Builder $builder) {
            $builder->where(static::TABLE . ".status", "<", static::ADMIN_THRESHOLD);
        });
    }
}
