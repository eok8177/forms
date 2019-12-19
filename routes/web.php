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

Route::get('/', ['as' => 'front.index', 'uses' => 'FrontendController@index']);
Route::get('/success', ['as' => 'front.success', 'uses' => 'FrontendController@success']);
Route::get('/form/{id}', ['as' => 'front.form', 'uses' => 'FrontendController@form']);

Auth::routes(['verify' => true]);

// Social login
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

// Admin
Route::group(['as' => 'admin.', 'middleware' => 'roles','roles' =>['admin', 'sadmin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::put('ajax/status', ['as' => 'ajax.status', 'uses' => 'AjaxController@status']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('entry/{entry}', ['as' => 'entry', 'uses' => 'DashboardController@entry']);

    Route::resource('user', 'UserController');
    Route::resource('form', 'FormController');
    Route::get('form/{form}/setting', ['as' => 'form.setting', 'uses' => 'FormController@setting']);
    Route::get('form/{form}/email', ['as' => 'form.email', 'uses' => 'FormController@email']);
    Route::put('form/{form}/email', ['as' => 'form.email.store', 'uses' => 'FormController@emailStore']);
    Route::post('ajax/form/{id}', ['as' => 'ajax.form', 'uses' => 'AjaxController@form']);
});

Route::group(['middleware' => ['roles', 'verified'],'roles' =>['user']], function() {
	Route::get('user', ['as' => 'user.index', 'uses' => 'UserController@index']);
	
    Route::get('user/edit', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
	Route::put('user/update', ['as' => 'user.update', 'uses' => 'UserController@update']);

	Route::get('user/security', ['as' => 'user.security', 'uses' => 'UserController@security']);
	Route::put('user/update_security', ['as' => 'user.update_security', 'uses' => 'UserController@update_security']);

    Route::get('user/form/{app}', ['as' => 'user.form', 'uses' => 'UserController@form']);
});


//Image resize & crop on view:  http://image.intervention.io/
Route::get('/resize/{w}/{h}',function($w=null, $h=null){
  $img = Illuminate\Support\Facades\Request::input("img");
  return \Image::make(public_path(urldecode($img)))->fit($w, $h, function ($constraint) {
      $constraint->upsize();
  })->response('jpg');
});