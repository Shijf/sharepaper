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


Route::get('/', 'PagesController@root')->name('home');

Route::any('/wechat', 'WeChatController@serve');



Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

    Route::get('/login','WeChatController@login')->name('login');

    Route::get('/getpaper','SharePaperController@getPaper');

});
Route::get('/wechat/logout', 'WeChatController@logout')->name('logout');

Route::get('/clearCache',function (){
    \Illuminate\Support\Facades\Cache::flush();
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function (){

    Route::get('/','AdminController@index')->name('index');
});




