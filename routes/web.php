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

/*
为 get 方法传递了两个参数，第一个参数指明了 URL，第二个参数指明了处理该 URL 的控制器动作。
name 方法用于命名路由。

resource 方法遵从 RESTful 架构为用户资源生成路由。该方法接收两个参数，第一个参数为资源名称，第二个参数为控制器名称。
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'StaticPagesController@about')->name('about');

// 用户注册、登录相关路由
Auth::routes();

// 用户 CRUD 路由
Route::resource('/users', 'UsersController');

// 用户关注视图路由
Route::get('/users/{user}/followings','UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers','UsersController@followers')->name('users.followers');

// 用户关注/取消关注操作路由
Route::post('/users/follows/{user}','FollowsController@store')->name('follows.store');
Route::delete('/users/follows/{user}','FollowsController@destroy')->name('follows.destroy');

// 知识清单 CRUD 路由
Route::resource('/repositories', 'RepositoriesController');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
