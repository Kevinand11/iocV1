<?php

namespace App\Observers;

use App\Events\NewOrChangedEmailEvent;
use App\Store;

class StoreObserver
{

    public function created(Store $store): void
    {
		event(new NewOrChangedEmailEvent($store));
    }

    public function updated(Store $store): void
    {
		if($store->isDirty('email')){
			event(new NewOrChangedEmailEvent($store));
		}
    }

    public function deleting(Store $store): void
    {
        foreach ($store->posts as $post) {
            $post->delete();
        }
        
        if($store->picture){
            $store->picture->delete();
        }
    }

    public function restored(Store $store): void
    {
        //
    }


    public function forceDeleted(Store $store): void
    {
        //
    }
}
