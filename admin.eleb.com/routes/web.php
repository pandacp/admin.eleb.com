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
//重置密码
Route::get('users/{user}/form','UserController@form')->name('users.form');
Route::patch('users/{user}reset/reset','UserController@reset')->name('users.reset');
//商家信息
Route::resource('shops','ShopController');
Route::get('shops/{shop}/check','ShopController@check')->name('shops.check');
Route::get('shops/{shop}/checked','ShopController@checked')->name('shops.checked');
//admin
Route::resource('admins','AdminController');
//重置密码
Route::get('admins/{admin}/form','AdminController@form')->name('admins.form');
Route::patch('admins/{admin}reset/reset','AdminController@reset')->name('admins.reset');
//登录
Route::get('login','SessionController@login')->name('login');
Route::post('login','SessionController@store')->name('login');
//注销
Route::delete('logout','SessionController@destroy')->name('logout');
//活动
Route::resource('activities','ActivityController');
//订单销量
Route::resource('orders','OrderController');
//权限管理
Route::resource('permissions','PermissionController');
//角色管理
Route::resource('roles','RoleController');


//文件上传
Route::post('upload',function(){
    $storage = \Illuminate\Support\Facades\Storage::disk('oss');
    $filename = $storage->putFile('shop_category',request()->file('file'));
    return [
        'filename'=>$storage->url($filename),
    ];
})->name('upload');
