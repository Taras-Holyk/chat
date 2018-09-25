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

    /**
     * @param User $user
     */
    public function updated(User $user)
    {
        $user->reindex();
    }

    /**
     * @param User $user
     */
    public function deleted(User $user)
    {
        $user->removeFromIndex();
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
