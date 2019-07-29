<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function created(Post $post)
    {
        //
    }

    public function updated(Post $post)
    {
        //
    }

    public function deleting(Post $post)
    {
        foreach ($post->pictures as $picture) {
            $picture->delete();
        }
    }

    public function restored(Post $post)
    {
        //
    }

    public function forceDeleted(Post $post)
    {
        //
    }
}
