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
//商家分类
Route::resource('shop_categories','Shop_categoryController');
//商家账号
Route::resource('users','UserController');
//商家信息
Route::resource('shops','ShopController');
Route::get('shops/{shop}/check','ShopController@check')->name('shops.check');
Route::get('shops/{shop}/checked','ShopController@checked')->name('shops.checked');
//admin
Route::resource('admins','AdminController');
Route::get('admins/{admin}/form','AdminController@form')->name('admins.form');
Route::patch('admins/{admin}reset/reset','AdminController@reset')->name('admins.reset');
//登录
Route::get('login','SessionController@login')->name('login');
Route::post('login','SessionController@store')->name('login');
//注销
Route::delete('logout','SessionController@destroy')->name('logout');

//