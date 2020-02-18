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


Route::group(['namespace' => 'Api'], function() {

    Route::get('/',  ['uses' => 'FormController@index']);
    Route::post('/post-form',  ['uses' => 'FormController@postForm']);
    Route::post('/upload-file',  ['uses' => 'FormController@uploadFile']);
    Route::post('/save-apps',  ['uses' => 'FormController@saveApp']);
    Route::post('/get-coords',  ['uses' => 'FormController@getCoords']);

});