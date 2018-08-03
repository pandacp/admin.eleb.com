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
//模板
//Route::group(['middleware'=>['role:分类管理员']],function(){
//
//});
Route::group(['middleware'=>['role:分类管理员']],function(){
    //商家分类
    Route::resource('shop_categories','Shop_categoryController');
});

Route::group(['middleware'=>['role:商家管理员']],function(){
    //商家账号
    Route::resource('users','UserController');
    //订单销量
    Route::resource('orders','OrderController');
    //商家信息
    Route::resource('shops','ShopController');
    Route::get('shops/{shop}/check','ShopController@check')->name('shops.check');
    Route::get('shops/{shop}/checked','ShopController@checked')->name('shops.checked');
});

Route::group(['middleware'=>['role:管理员']],function(){
    //重置用户密码
    Route::get('users/{user}/form','UserController@form')->name('users.form');
    Route::patch('users/{user}reset/reset','UserController@reset')->name('users.reset');
    //admin管理员
    Route::resource('admins','AdminController');
    //重置管理员密码
    Route::get('admins/{admin}/form','AdminController@form')->name('admins.form');
    Route::patch('admins/{admin}reset/reset','AdminController@reset')->name('admins.reset');
});

//登录
Route::get('login','SessionController@login')->name('login');
Route::post('login','SessionController@store')->name('login');
//注销
Route::delete('logout','SessionController@destroy')->name('logout');

//活动
Route::resource('activities','ActivityController');

Route::group(['middleware'=>['role:超级管理员']],function(){
//权限管理
    Route::resource('permissions','PermissionController');
//角色管理
    Route::resource('roles','RoleController');
//菜单管理
    Route::resource('cds','CdController');
});

Route::group(['middleware'=>['role:活动管理员']],function(){
    //抽奖活动管理
        Route::resource('events','EventController');
    //活动奖品管理
        Route::resource('event_prizes','Event_prizeController');
});

//抽奖
//Route::resource('lotteries','LotteryController');
//抽奖人数信息
Route::get('sign_ups','EventController@sign_up')->name('sign_up');



//文件上传
Route::post('upload',function(){
    $storage = \Illuminate\Support\Facades\Storage::disk('oss');
    $filename = $storage->putFile('shop_category',request()->file('file'));
    return [
        'filename'=>$storage->url($filename),
    ];
})->name('upload');
