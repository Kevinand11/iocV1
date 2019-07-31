<?php

namespace App\Observers;

use App\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        //
    }

    public function updated(Category $category): void
    {
        //
    }

    public function deleting(Category $category): void
    {
        foreach ($category->posts as $post) {
            $post->delete();
        }

        foreach ($category->subs as $sub) {
            $sub->delete();
        }

    }

    public function restored(Category $category): void
    {
        //
    }

    public function forceDeleted(Category $category): void
    {
        //
    }
}
