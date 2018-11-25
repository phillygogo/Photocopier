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
    Route::get('/facebook/getAlbums', 'FacebookController@getAlbums');
    Route::get('/facebook/decision/{albumId}/{albumName}', 'FacebookController@decision');
    Route::get('/facebook/savePhotos/{decision}', 'FacebookController@savePhotos');
    Route::get('/facebook/getGoogleAccessToken', 'FacebookController@getGoogleAccessToken');
    Route::get('/facebook/savePhotosGoogleDrive', 'FacebookController@savePhotosGoogleDrive');

});

Route::group(['middleware' => ['googleDrive']], function () {
    Route::get('/googleDrive', 'GoogleDriveController@index');

});
