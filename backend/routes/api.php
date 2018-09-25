<?php

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

Route::prefix('v1')->group(function () {
    $this->post('login', 'Auth\LoginController@login');
    $this->post('register', 'Auth\RegisterController@register');

    Route::middleware('auth:api')->group(function () {
        $this->post('logout', 'Auth\LoginController@logout')->name('logout');
    });
});