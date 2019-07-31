<?php

use App\Category;
use App\Picture;
use App\Post;
use App\Store;
use App\User;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class DatabaseSeeder extends Seeder
{
    public function run(): Void
    {
        factory(User::class,20)->create()->each(static function($user){
			$name = $user->id.'.png';
			Image::canvas(300,300)->save(public_path('img/users/').$name);
            Picture::create([
                'imageable_id' => $user->id,
                'imageable_type' => 'App\User',
                'filename' => 'img/users/'.$name
            ]);
        });
        factory(Store::class,20)->create()->each(static function($store){
			$name = $store->id.'.png';
			Image::canvas(300,300)->save(public_path('img/stores/').$name);
            Picture::create([
                'imageable_id' => $store->id,
                'imageable_type' => 'App\Store',
                'filename' => 'img/stores/'.$name
            ]);
        });
        factory(Post::class,50)->create()->each(static function($post){
        	$name = $post->id.'.png';
        	Image::canvas(300,300)->save(public_path('img/posts/').$name);
            Picture::create([
                'imageable_id' => $post->id,
                'imageable_type' => 'App\Post',
                'filename' => 'img/posts/'.$name
            ]);
        });
        factory(Category::class,20)->create();
    }
}
