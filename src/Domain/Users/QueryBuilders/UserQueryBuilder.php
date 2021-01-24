<?php

namespace Domain\Users\QueryBuilders;

use App\Exceptions\SessionUuidUserNotFoundException;
use Domain\Users\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\UuidInterface;

class UserQueryBuilder extends Builder
{
    public function notAdmin(): self
    {
        return $this->where("status", "<", User::ADMIN_THRESHOLD);
    }

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

    public function fistBySessionUuidOrFail(UuidInterface $sessionUuid): User
    {
        $user = $this->firstBySessionUuid($sessionUuid);
        if (!$user) throw new SessionUuidUserNotFoundException();

        return $user;
    }
}
