<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('login','Admin\LoginController@login');
Route::get('Admin/loginout','Admin\LoginController@loginout');
Route::any('Admin/code','Admin\LoginController@code');

Route::group(['prefix'=>'Admin','namespace'=>'Admin','middleware'=>['auth']],function(){
    Route::any('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::resource('Dept','DeptController');
    Route::post('Dept/changeorder','DeptController@changeorder');
    Route::resource('user','UserController');
    Route::resource('article','ArticleController');
    Route::any('email/write','EmailController@write');
    Route::any('upload','EmailController@upload');
    Route::any('email/show/{show}','EmailController@show');
    Route::any('email/edit/{show}','EmailController@edit');
    Route::any('email/sent','EmailController@sent');
    Route::any('email/download/{download}','EmailController@download');

    Route::any('email/read','EmailController@read');
    Route::delete('email/{email}','EmailController@del');
});

