<?php

Route::resource('posts', 'PostController');

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'UserController@index')->name('users.index');
Route::get('/edit/{id}/{status}', 'UserController@updateStatus')->name('users.updateStatus');
Route::post('/user/resetCode', 'UserController@resetCode')->name('users.resetCode');
Route::get('/user/code', 'UserController@code')->name('users.code');


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('loginAdmin');

Route::get('/phone/{phone}', 'PostController@phone')->name('phone');