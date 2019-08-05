<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', static function (Request $request) {
    return $request->user();
});
Route::prefix('/v1')->group(static function() {
	Route::get('users/paginate', 'API\\v1\\UsersController@paginate');
	Route::get('posts/paginate', 'API\\v1\\PostsController@paginate');
	Route::get('categories/paginate', 'API\\v1\\CategoriesController@paginate');
	Route::get('stores/paginate', 'API\\v1\\StoresController@paginate');
	Route::get('pictures/paginate', 'API\\v1\\PicturesController@paginate');

	Route::get('auth/profile', 'API\\v1\\AuthController@profile');
	Route::put('auth/update', 'API\\v1\\AuthController@update');
	Route::put('auth/updateStore', 'API\\v1\\AuthController@updateStore');
	Route::post('auth/login', 'API\\v1\\AuthController@login');
	Route::post('auth/register', 'API\\v1\\AuthController@register');
	Route::post('auth/logout', 'API\\v1\\AuthController@logout');
	
	Route::apiResources([
		'categories' => 'API\\v1\\CategoriesController',
		'pictures' => 'API\\v1\\PicturesController',
		'posts' => 'API\\v1\\PostsController',
		'stores' => 'API\\v1\\StoresController',
		'users' => 'API\\v1\\UsersController',
	]);
});
