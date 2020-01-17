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
    });

    Route::post('login', 'Auth\PassportAuthController@login')->name('auth.login');
    Route::post('register', 'Auth\PassportAuthController@register')->name('auth.register');
});

Route::group(['prefix' => '/admin/',  'middleware' => ['multi-auth', 'admin']], function() {
    Route::prefix('event/')->group(function () {
        Route::post('create', 'EventController@store')->name('event.create');
        Route::patch('rules/edit', 'EventRulesController@update')->name('event.rules.update');
    });
});

Route::group(['prefix' => '/event/',  'middleware' => ['multi-auth']], function() {
    Route::post('register', 'EventRegistrationsController@store')->name('event.register');
    Route::get('latest', 'EventController@latest')->name('event.latest');
    Route::get('{id}/registration', 'EventController@registered')->name('event.registered');
});