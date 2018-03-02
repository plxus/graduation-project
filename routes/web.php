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
*/

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup','UsersController@create')->name('signup');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
