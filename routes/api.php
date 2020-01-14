<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, provider');
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
Route::get('/', 'IndexController');
Route::prefix('/auth/')->group(function () {
    
    Route::get('{provider}/redirect', 'Auth\SocialiteController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\SocialiteController@handleProviderCallback');

    Route::middleware('multi-auth')->group(function () {
        
        Route::get('user', 'Auth\UserController');
        Route::post('/logout', 'Auth\PassportAuthController@logout')->name('auth.logout');
    
        Route::middleware('admin')->group(function () {    
           
            Route::post('event/create', 'EventController@store')->name('event.create');
        
        });
    
    });

    Route::post('login', 'Auth\PassportAuthController@login')->name('auth.login');
    Route::post('register', 'Auth\PassportAuthController@register')->name('auth.register');
});