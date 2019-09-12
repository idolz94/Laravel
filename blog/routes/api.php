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

Route::get('music','MusicController@index');

Route::get('create','MusicController@create');
Route::get('listCate','MusicController@listCate');
Route::get('listMusicCate/{name}','MusicController@listMusicCate');
Route::get('getFile','MusicController@getFile');
Route::get('storeCate','MusicController@storeCate');
Route::get('storeMusic/{name}','MusicController@storeMusic');
Route::post('music','MusicController@store')->name('music.store');
