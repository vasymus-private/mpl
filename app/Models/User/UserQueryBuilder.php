<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\UuidInterface;

class UserQueryBuilder extends Builder
{
    public function whereSessionUuid(UuidInterface $sessionUuid): self
    {
        /** @see User::$userSessionUuids */
        return $this->whereHas("userSessionUuids", function(Builder $builder) use($sessionUuid) {
            $builder->whereKey($sessionUuid->toString());
        });
    }

    public function firstBySessionUuid(UuidInterface $sessionUuid): ?User
    {
        return $this->whereSessionUuid($sessionUuid)->first();
    }
}
