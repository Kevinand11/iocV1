<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', static function () {
    return view('home');
});

Route::get('/{path}', static function(){
    return view('home');
})->where('path',"([A-z\d\/_.]+)?");


/* Auth routes are registered under here so that Vue can control the login and
    register forms as any get request sent is intercepted by the two defined routes
    and returns the home page
*/
Auth::routes();


