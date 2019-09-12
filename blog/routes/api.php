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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getFile','MusicController@getFileDB');

Route::get('/','MusicController@index');
Route::get('listCate','MusicController@listCate');
Route::get('show/{id}','MusicController@show');
Route::get('getDownload/{name}','MusicController@getDownload')->name('getDownload');
// Route::get('storeCate','MusicController@storeCate');
// Route::get('storeMusic/{name}','MusicController@storeMusic');
