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

Route::get('/admins/read', 'AdminController@index')->middleware(['multi-auth', 'admin']);

Route::group(['prefix' => '/admin/',  'middleware' => ['multi-auth', 'admin']], function() {
    
    Route::get('search', 'AdminController@search');
    Route::patch('{user}/update', 'AdminController@update');
    
    Route::prefix('event/')->group(function () {
        Route::post('create', 'EventController@store')->name('event.create');
        Route::delete('{event}/delete', 'EventController@destroy')->name('event.delete');
        Route::patch('rules/update', 'EventRulesController@update')->name('event.rules.update');
        
        Route::put('registration/{hashid}/update', 'EventRegistrationsController@update')->name('event.registration.update');
        Route::patch('registration/{registration}/update', 'EventRegistrationsController@patch')->name('event.registration.patch');
        Route::get('{event}/registrations/read', 'EventRegistrationsController@index')->name('event.registrations.index');
        Route::post('notification/create', 'EventNotificationsController@store')->name('event.notification.create');
    });
    Route::prefix('placement/')->group(function () {
        Route::post('room/create', 'RoomController@store');
        Route::delete('room/{room}/delete', 'RoomController@destroy');
        Route::get('rooms/read', 'RoomController@show');
        Route::patch('room/update', 'EventRegistrationsController@updateRoom');
    });
});

Route::group(['prefix' => '/event/',  'middleware' => ['multi-auth']], function() {
    Route::get('latest', 'EventController@latest')->name('event.latest');
    Route::post('register', 'EventRegistrationsController@store')->name('event.register');
    Route::get('{event}/registration', 'EventRegistrationsController@show')->name('event.registered');
    Route::get('rules/{id}/read', 'EventRulesController@show')->name('event.rules.show');
    Route::get('{event}/notifications/read', 'EventNotificationsController@show')->name('event.notification.show');
});

Route::group(['prefix' =>'/push-notification/', 'middleware' => ['multi-auth']], function() {
    Route::post('/subscribe','PushController@store');
});
