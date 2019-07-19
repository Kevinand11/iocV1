<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users/paginate', "API\UsersController@paginate");
Route::get('posts/paginate', "API\PostsController@paginate");
Route::get('categories/paginate', "API\CategoriesController@paginate");

Route::post("users/login","API\UsersController@login");
Route::post("users/register","API\UsersController@register");
Route::post("users/logout","API\UsersController@logout");

Route::apiResources([
    "users" => "API\UsersController", 
    "posts" => "API\PostsController", 
    "categories" => "API\CategoriesController", 
]);