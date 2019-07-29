<?php

namespace App\Observers;

use App\Store;

class StoreObserver
{

    public function created(Store $store)
    {
        //
    }

    public function updated(Store $store)
    {
        //
    }

    public function deleting(Store $store)
    {
        foreach ($store->posts as $post) {
            $post->delete();
        }
        
        if($store->picture){
            $store->picture->delete();
        }
    }

    public function restored(Store $store)
    {
        //
    }


    public function forceDeleted(Store $store)
    {
        //
    }
}
