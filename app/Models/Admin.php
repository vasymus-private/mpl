<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("admin", function(Builder $builder) {
            $builder->where(static::TABLE . ".status", ">=", static::ADMIN_THRESHOLD);
        });
    }

    public static function firstOrCreateAnonymous(string $anonymousUid): User
    {
        throw new \LogicException("Can not create anonymous admin");
    }


}
