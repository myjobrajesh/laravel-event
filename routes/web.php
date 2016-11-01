<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@home');

Route::get('/event/{id}', [
            'uses' => 'EventController@viewEvent',
            'as'   => 'event'
        ]);

Route::get('/eventover/{id}', [
            'uses' => 'EventController@eventOver',
            'as'   => 'eventover'
        ]);

        
Route::get('/register/{id}', [
            'uses' => 'UserController@registerStandShow',
            'as'   => 'registerStand'
        ]);
        
Route::post('/register', [
            'uses' => 'UserController@saveRegistration',
            'as'   => 'registersave'
        ]);
