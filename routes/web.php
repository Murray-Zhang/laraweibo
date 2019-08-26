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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup');

Route::resource('users', 'UsersController');

//显示登陆页面
Route::get('/login', 'SessionsController@create')->name('login');
//创建登陆会话
Route::post('/login', 'SessionsController@store')->name('login');
//退出，销毁会话
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

//邮件认证
Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');


//密码重设
//显⽰重置密码的邮箱发送⻚⾯
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//密码更新⻚⾯
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//执⾏密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//微博的创建和删除路由
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);