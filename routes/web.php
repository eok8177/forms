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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Social login
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

// Admin
Route::group(['as' => 'admin.', 'middleware' => 'roles','roles' =>['admin', 'sadmin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::put('ajax/status', ['as' => 'ajax.status', 'uses' => 'AjaxController@status']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::resource('user', 'UserController');
    Route::resource('form', 'FormController');
    Route::post('ajax/form/{id}', ['as' => 'ajax.form', 'uses' => 'AjaxController@form']);
});



//Image resize & crop on view:  http://image.intervention.io/
Route::get('/resize/{w}/{h}',function($w=null, $h=null){
  $img = Illuminate\Support\Facades\Request::input("img");
  return \Image::make(public_path(urldecode($img)))->fit($w, $h, function ($constraint) {
      $constraint->upsize();
  })->response('jpg');
});