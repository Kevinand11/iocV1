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
        factory(User::class,20)->create()->each(function($user){
            Picture::create([
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'filename' => 'img/users/'.time().'.png'
            ]);
        });
        factory(Store::class,20)->create()->each(function($store){
            Picture::create([
                'imageable_id' => $store->id,
                'imageable_type' => 'App\Store',
                'filename' => 'img/stores/'.time().'.png'
            ]);
        });
        factory(Post::class,100)->create()->each(function($post){
            Picture::create([
                'imageable_id' => $post->id,
                'imageable_type' => 'App\Post',
                'filename' => 'img/posts/'.time().'.png'
            ]);
        });
        factory(Category::class,20)->create();
    }
}
