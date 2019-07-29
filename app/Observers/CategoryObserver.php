<?php

namespace App\Observers;

use App\Category;

class CategoryObserver
{
    public function created(Category $category)
    {
        //
    }

    public function updated(Category $category)
    {
        //
    }

    public function deleting(Category $category)
    {
        foreach ($category->posts as $post) {
            $post->delete();
        }

        foreach ($category->subs as $sub) {
            $sub->delete();
        }

    }

    public function restored(Category $category)
    {
        //
    }

    public function forceDeleted(Category $category)
    {
        //
    }
}
