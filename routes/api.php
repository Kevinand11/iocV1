<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', static function (Request $request) {
    return $request->user();
});

Route::get('users/paginate', "API\UsersController@paginate");
Route::get('posts/paginate', "API\PostsController@paginate");
Route::get('categories/paginate', "API\CategoriesController@paginate");
Route::get('stores/paginate', "API\StoresController@paginate");
Route::get('pictures/paginate', "API\PicturesController@paginate");

Route::get('users/profile',"API\UsersController@profile");
Route::post('users/login',"API\UsersController@login");
Route::post('users/register',"API\UsersController@register");
Route::post('users/logout',"API\UsersController@logout");

Route::apiResources([
    'categories' => "API\CategoriesController",
    'pictures' => "API\PicturesController",
    'posts' => "API\PostsController",
    'stores' => "API\StoresController",
    'users' => "API\UsersController",
]);
