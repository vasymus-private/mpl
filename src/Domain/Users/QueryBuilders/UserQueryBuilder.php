<?php

namespace Domain\Users\QueryBuilders;

use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function notAdmin(): self
    {
        return $this->where("status", "<", BaseUser::ADMIN_THRESHOLD);
    }
}
