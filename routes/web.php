<?php
use Encore\Admin\Middleware\Pjax;

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

// 首页路由
Route::get('/', 'HomeController@index')->name('home');

// 搜索路由
Route::get('/search', 'HomeController@search')->name('search');

// 关于页路由
Route::get('/about', 'StaticPagesController@about')->name('about');

// 用户注册、登录相关路由
Auth::routes();

// 用户 CRUD 路由
Route::resource('/users', 'UsersController');

// 知识清单 CRUD 路由
Route::resource('/repositories', 'RepositoriesController');

// 用户设置类别偏好操作路由
Route::post('/users/preferences/{user}','UsersController@preferences')->name('users.preferences');

// 用户收藏知识清单列表视图路由
Route::get('/users/{user}/stars','UsersController@stars')->name('users.stars');

// 用户关注列表视图路由
Route::get('/users/{user}/followings','UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers','UsersController@followers')->name('users.followers');

// 用户关注/取消关注操作路由
Route::post('/users/follows/{user}','FollowsController@store')->name('follows.store');
Route::delete('/users/follows/{user}','FollowsController@destroy')->name('follows.destroy');

// 用户收藏/取消收藏知识清单操作路由
Route::post('/users/stars/{repository}', 'StarsController@store')->name('stars.store');
Route::delete('/users/stars/{repository}', 'StarsController@destroy')->name('stars.destroy');

// 通知与私信视图路由
Route::get('/notifications', 'NotificationsController@show')->name('notifications.show');

// 发送、删除通知与私信操作路由
Route::post('/notifications/{user}', 'NotificationsController@store')->name('notifications.store');
Route::patch('/notifications/{msg}', 'NotificationsController@update')->name('notifications.update');

// Voyager 管理后台路由
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
