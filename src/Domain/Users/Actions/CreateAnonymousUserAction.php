<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User\User;

class CreateAnonymousUserAction
{
    public function execute(): User
    {
        $user = User::create();
        return User::query()->findOrFail($user->id);
    }
}
