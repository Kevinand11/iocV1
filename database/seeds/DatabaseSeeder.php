<?php

use App\Category;
use App\Picture;
use App\Post;
use App\Store;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): Void
    {
        factory(User::class,20)->create();
        factory(Store::class,20)->create();
        factory(Post::class,100)->create();
        factory(Picture::class,100)->create();
        factory(Category::class,20)->create();
    }
}
