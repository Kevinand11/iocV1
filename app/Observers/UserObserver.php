<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function created(User $user)
    {
        //
    }

    public function updated(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        if($user->store) {
            $user->store->delete();
        }

        if($user->picture){
            $user->picture->delete();
        }
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
