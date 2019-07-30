<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->passportToken = $user->createToken('Auth Token')->accessToken;
        $user->save();
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleting(User $user): void
    {
        if($user->store) {
            $user->store->delete();
        }

        if($user->picture){
            $user->picture->delete();
        }
    }

    public function restored(User $user): void
    {
        //
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
