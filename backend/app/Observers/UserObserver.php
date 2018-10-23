<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * @param User $user
     * @throws \Exception
     */
    public function created(User $user)
    {
        $user->addToIndex();
    }
}
