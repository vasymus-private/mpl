<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User\User;

class CreateAnonymousUserAction
{
    public function execute(): User
    {
        return User::create();
    }
}
