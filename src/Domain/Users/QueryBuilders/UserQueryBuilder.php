<?php

namespace Domain\Users\QueryBuilders;

use Domain\Users\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function notAdmin(): self
    {
        return $this->where("status", "<", User::ADMIN_THRESHOLD);
    }
}
