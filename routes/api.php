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

Route::get('auth/profile',"API\AuthController@profile");
Route::post('auth/login',"API\AuthController@login");
Route::post('auth/register',"API\AuthController@register");
Route::post('auth/logout',"API\AuthController@logout");

Route::apiResources([
    'categories' => "API\CategoriesController",
    'pictures' => "API\PicturesController",
    'posts' => "API\PostsController",
    'stores' => "API\StoresController",
    'users' => "API\UsersController",
]);
