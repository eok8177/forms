<?php

use Illuminate\Support\Facades\Route;

/**
* Description:
* Web Routes
* Here is where you can register web routes for your application. These
* routes are loaded by the RouteServiceProvider within a group which
* contains the "web" middleware group. Now create something great!
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/

Route::group(['middleware' => ['roles', 'verified'],'roles' =>['user', 'admin', 'manager']], function() {
    Route::get('/', ['as' => 'front.index', 'uses' => 'UserController@redirectTo']);
});

Route::get('/registered', function () {
    return view('registered');
})->name('front.registered');

Route::get('/success/{id}', ['as' => 'front.success', 'uses' => 'FrontendController@success']);
Route::get('/form/{id?}', ['as' => 'front.form', 'uses' => 'FrontendController@form']);
Route::get('/all-forms', ['as' => 'front.all_forms', 'uses' => 'FrontendController@allForms']);

Auth::routes(['verify' => true]);
Route::get('/redirect-to', ['as' => 'redirect', 'uses' => 'UserController@redirectTo']);

Route::view('/privacy-policy', 'privacy-policy')->name('privacy-policy');


// Social login
Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

// Manager
Route::group(['as' => 'manager.', 'middleware' => ['roles', 'verified'],'roles' =>['admin','manager','outreach'], 'namespace' => 'Manager', 'prefix' => 'manager'], function() {

    Route::get('responses', ['as' => 'responses', 'uses' => 'ResponseController@index']);
    Route::get('response/{application}', ['as' => 'response', 'uses' => 'ResponseController@response']);
    Route::post('response-status/{application}', ['as' => 'responseStatus', 'uses' => 'ResponseController@status']);

    Route::resource('user', 'UserController');
});

// Admin
Route::group(['as' => 'admin.', 'middleware' => 'roles','roles' =>['admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {

    Route::put('ajax/status', ['as' => 'ajax.status', 'uses' => 'AjaxController@status']);
    Route::put('ajax/reorder', ['as' => 'ajax.reorder', 'uses' => 'AjaxController@reorder']);
    Route::put('ajax/set-time', ['as' => 'ajax.setTime', 'uses' => 'AjaxController@setTime']);

    Route::resource('form', 'FormController');
    Route::get('form/{form}/setting', ['as' => 'form.setting', 'uses' => 'FormController@setting']);
    Route::get('form/{form}/email', ['as' => 'form.email', 'uses' => 'FormController@email']);
    Route::put('form/{form}/email', ['as' => 'form.email.store', 'uses' => 'FormController@emailStore']);
    Route::get('form/{form}/copy', ['as' => 'form.copy', 'uses' => 'FormController@copy']);
    Route::post('ajax/form/{id}', ['as' => 'ajax.form', 'uses' => 'AjaxController@form']);
    Route::put('form/{form}/alias', ['as' => 'form.alias', 'uses' => 'FormController@alias']);

    Route::resource('page', 'PageController');
    Route::resource('faq', 'FaqController');
    Route::resource('news', 'NewsController');

    Route::post('user/sadmin', ['as' => 'user.sadmin', 'uses' => 'UserController@setSAdmin']);
    Route::put('users/sendemail/{id}', ['as' => 'user.sendemail', 'uses' => 'UserController@sendVerifyEmail']);

    Route::resource('form-type', 'FormTypeController');
    Route::resource('group', 'GroupController');

    Route::get('settings',  ['as' => 'settings', 'uses' => 'SettingController@index']);
    Route::post('settings', ['as' => 'settings.update', 'uses' => 'SettingController@update']);
    Route::get('setting/crypt/{value}',  ['as' => 'setting.crypt', 'uses' => 'SettingController@crypt']);


    Route::put('response/{app}/sendemail', ['as' => 'app.sendemail', 'uses' => 'ResponseController@sendEmail']);
    Route::delete('response/{app}', ['as' => 'app.destroy', 'uses' => 'ResponseController@destroy']);

    Route::get('responses', ['as' => 'responses', 'uses' => 'ResponseController@index']);
    Route::get('entry/{app}', ['as' => 'entry', 'uses' => 'ResponseController@entry']);

    Route::resource('user', 'UserController');

    Route::get('apilogs', ['as' => 'apilogs', 'uses' => 'LogController@apilogs']);
});

// User
Route::group(['middleware' => ['roles', 'verified'],'roles' =>['admin', 'user', 'outreach']], function() {
	Route::get('user', ['as' => 'user.index', 'uses' => 'UserController@index']);
	
    Route::get('user/edit', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
	Route::put('user/update', ['as' => 'user.update', 'uses' => 'UserController@update']);


    Route::get('grants', ['as' => 'user.grants', 'uses' => 'GrantController@index']);

    Route::get('user/form/{app}', ['as' => 'user.form', 'uses' => 'UserController@form']);
    Route::delete('user/form/{app}', ['as' => 'user.form.destroy', 'uses' => 'UserController@destroy']);
    Route::get('user/form-view/{app}', ['as' => 'user.formView', 'uses' => 'UserController@formView']);
    Route::get('user/faq', ['as' => 'user.faq', 'uses' => 'UserController@faq']);

    Route::get('user/draft-saved/{form}', ['as' => 'user.draftSaved', 'uses' => 'UserController@draftSaved']);

    Route::get('user/contact', ['as' => 'user.contact', 'uses' => 'UserController@contact']);
    Route::post('user/contact', ['as' => 'user.contact', 'uses' => 'UserController@contactSend']);
});

// Outreach user
Route::group(['middleware' => ['roles', 'verified'],'roles' =>['admin', 'outreach']], function() {
    Route::get('outreachservices', ['as' => 'user.outreachservices', 'uses' => 'OutreachserviceController@index']);
    Route::post('outreachservices', ['as' => 'user.outreachservices', 'uses' => 'OutreachserviceController@getOutreachServices']);
    Route::post('outreachservicevisits', ['as' => 'user.outreachservicevisits', 'uses' => 'OutreachserviceController@getOutreachServiceVisits']);
});

//Image resize & crop on view:  http://image.intervention.io/
Route::get('/resize/{w}/{h}','ImageController@index')->name('resize');