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

Route::get('/', 'PhotoController@index');
Route::get('/savePhotosToComputer', 'PhotoController@savePhotosToComputer');

Route::get('/facebook', 'FacebookController@index')->middleware('facebook');
Route::get('/facebook/getToken', 'FacebookController@getToken');
