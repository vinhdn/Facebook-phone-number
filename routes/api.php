<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'ApiController@doLogin')->name('doLogin');

Route::middleware('auth:api')->get('/phonebyid', 'ApiController@phone')->name('phone');
Route::middleware('auth:api')->get('/searchLog', 'ApiController@searchLog')->name('searchLog');