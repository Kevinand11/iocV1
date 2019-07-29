<?php

namespace App\Providers;

use App\Category;
use App\Picture;
use App\Post;
use App\Store;
use App\User;
use App\Observers\CategoryObserver;
use App\Observers\PictureObserver;
use App\Observers\PostObserver;
use App\Observers\StoreObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Picture::observe(PictureObserver::class);
        Post::observe(PostObserver::class);
        Store::observe(StoreObserver::class);
        User::observe(UserObserver::class);
    }
}
