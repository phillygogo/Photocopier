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

Route::get('/', 'AppController@index');
Route::get('/facebook/getToken', 'FacebookController@getToken');

Route::group(['middleware' => ['facebook']], function () {
    Route::get('/facebook/albums', 'FacebookController@albums');
    Route::get('/facebook/decision/{albumId}/{albumName}', 'FacebookController@decision');
    Route::get('/facebook/savePhotosToComputer/{albumId}/{albumName}', 'FacebookController@savePhotosToComputer');
});

Route::group(['middleware' => ['googleDrive']], function () {
    Route::get('/googleDrive', 'GoogleDriveController@index');

});
Route::get('/googleDrive/getAccessToken', 'GoogleDriveController@getAccessToken');
