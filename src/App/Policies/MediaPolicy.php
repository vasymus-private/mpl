<?php

namespace App\Policies;

use Domain\Users\Models\User\User;

class MediaPolicy extends BasePolicy
{
    public function show(User $authUser, User $user): bool
    {
        return (string)$authUser->id === (string)$user->id;
    }
}
