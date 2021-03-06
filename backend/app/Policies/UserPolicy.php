<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function createChat(User $viewer, User $user) : bool
    {
        return $viewer->id != $user->id;
    }
}
