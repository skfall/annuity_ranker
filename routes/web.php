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

Route::group(['middleware' => ['web', 'auth'], 'prefix' => Config::get('app.routeLang')], function () {
	Route::get('/', 'PagesController@home')->name('home');
	Route::get('/page/{page}', 'PagesController@manual')->name('manual');
	Route::get('/ranks/{annuity}', 'PagesController@ranks')->name('ranks');
});

Route::group(['middleware' => ['ajax']], function () {
	Route::post('/ajax/', 'AjaxController@reception');	
});
