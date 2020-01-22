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
Route::get('/success/{id}', ['as' => 'front.success', 'uses' => 'FrontendController@success']);
Route::get('/form/{id?}', ['as' => 'front.form', 'uses' => 'FrontendController@form']);

Auth::routes(['verify' => true]);
Route::get('/redirect-to', ['as' => 'redirect', 'uses' => 'UserController@redirectTo']);

// Social login
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

// Manager
Route::group(['as' => 'admin.', 'middleware' => 'roles','roles' =>['admin', 'manager'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::get('responses', ['as' => 'responses', 'uses' => 'ResponseController@index']);
    Route::get('entry/{entry}', ['as' => 'entry', 'uses' => 'ResponseController@entry']);
    Route::get('entry-status/{entry}/{status}', ['as' => 'entryStatus', 'uses' => 'ResponseController@status']);
    Route::post('entry-reject', ['as' => 'entryReject', 'uses' => 'ResponseController@statusReject']);

    Route::resource('user', 'UserController');
});

// Admin
Route::group(['as' => 'admin.', 'middleware' => 'roles','roles' =>['admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::put('ajax/status', ['as' => 'ajax.status', 'uses' => 'AjaxController@status']);
    Route::put('ajax/reorder', ['as' => 'ajax.reorder', 'uses' => 'AjaxController@reorder']);

    Route::resource('form', 'FormController');
    Route::get('form/{form}/setting', ['as' => 'form.setting', 'uses' => 'FormController@setting']);
    Route::get('form/{form}/email', ['as' => 'form.email', 'uses' => 'FormController@email']);
    Route::put('form/{form}/email', ['as' => 'form.email.store', 'uses' => 'FormController@emailStore']);
    Route::get('form/{form}/copy', ['as' => 'form.copy', 'uses' => 'FormController@copy']);
    Route::post('ajax/form/{id}', ['as' => 'ajax.form', 'uses' => 'AjaxController@form']);

    Route::resource('page', 'PageController');
    Route::resource('faq', 'FaqController');

    Route::post('user/sadmin', ['as' => 'user.sadmin', 'uses' => 'UserController@setSAdmin']);
    Route::put('users/sendemail/{id}', ['as' => 'user.sendemail', 'uses' => 'UserController@sendVerifyEmail']);
});

// User
Route::group(['middleware' => ['roles', 'verified'],'roles' =>['user']], function() {
	Route::get('user', ['as' => 'user.index', 'uses' => 'UserController@index']);
	
    Route::get('user/edit', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
	Route::put('user/update', ['as' => 'user.update', 'uses' => 'UserController@update']);

	Route::get('user/security', ['as' => 'user.security', 'uses' => 'UserController@security']);
	Route::put('user/update_security', ['as' => 'user.update_security', 'uses' => 'UserController@update_security']);

    Route::get('user/form/{app}', ['as' => 'user.form', 'uses' => 'UserController@form']);
    Route::delete('user/form/{app}', ['as' => 'user.form.destroy', 'uses' => 'UserController@destroy']);
});


//Image resize & crop on view:  http://image.intervention.io/
Route::get('/resize/{w}/{h}',function($w=null, $h=null){
  $img = Illuminate\Support\Facades\Request::input("img");
  return \Image::make(public_path(urldecode($img)))->fit($w, $h, function ($constraint) {
      $constraint->upsize();
  })->response('jpg');
});