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

Route::group(['prefix'=>'date'], function(){
    Route::get('/', 'DateController@login');
    Route::get('/login', 'DateController@login')->name('date.login');
    Route::post('/login_post', 'DateController@login_post')->name('date.login_post');
    Route::get('/data', 'DateController@data')->name('date.data');
    // Route::post('/data_post', 'DateController@data_post');
    // Route::post('/respond_post', 'DateController@respond_post');
    Route::get('/logout', 'DateController@logout');
    // Route::get('/restaurant', 'DateController@restaurant');
    // Route::get('/pair_time', 'DateController@pair_time');
    // Route::get('/test', 'DateController@test');
}); 
    
Route::group(['prefix'=>'activity'], function(){
    Route::get('/', 'TestController@index');
  
});