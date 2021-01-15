<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function whereSessionUuid(string $sessionUuid): self
    {
        /** @see User::$userSessionUuids */
        return $this->whereHas("userSessionUuids", function(Builder $builder) use($sessionUuid) {
            $builder->whereKey($sessionUuid);
        });
    }

    public function firstBySessionUuid(string $sessionUuid): self
    {
        return $this->whereSessionUuid($sessionUuid)->first();
    }
}
