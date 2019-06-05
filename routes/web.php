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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Controller@index');
Route::get('/vueTut', 'Controller@vueTut');
Route::get('/facebook/getToken', 'FacebookController@getToken');

Route::group(['middleware' => ['facebook']], function () {
    Route::get('/facebook/getAlbums', 'FacebookController@getAlbums');
    Route::get('/facebook/decision/{albumId}/{albumName}', 'FacebookController@decision');
    Route::get('/facebook/savePhotos/{decision}', 'FacebookController@savePhotos');
    Route::get('/facebook/getGoogleAccessToken', 'FacebookController@getGoogleAccessToken');
    Route::get('/facebook/savePhotosGoogleDrive', 'FacebookController@savePhotosGoogleDrive');

});
