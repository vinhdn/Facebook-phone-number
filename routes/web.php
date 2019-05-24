<?php

Route::resource('posts', 'PostController');

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'UserController@index')->name('users.index');
Route::get('/edit/{id}/{status}', 'UserController@updateStatus')->name('users.updateStatus');
Route::post('/user/resetCode', 'UserController@resetCode')->name('users.resetCode');
Route::get('/user/code', 'UserController@code')->name('users.code');
Route::get('/user/resetPasswordIndex/{id}', 'UserController@resetPasswordIndex')->name('users.resetPasswordIndex');
Route::post('/user/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('loginAdmin');