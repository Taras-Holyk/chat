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
    $this->post('login', 'Auth\LoginController@login')->name('login');
    $this->post('register', 'Auth\RegisterController@register');

    Route::middleware('auth:api')->group(function () {
        $this->post('logout', 'Auth\LoginController@logout')->name('logout');

        $this->get('users', 'UserController@index');

        Route::prefix('chats')->group(function () {
            $this->get('', 'ChatController@index');
            $this->get('{chat}', 'ChatController@show');
            $this->post('{chatUserId}', 'ChatController@store');
            $this->get('{chat}/relationships/messages', 'MessageController@index');
            $this->post('{chat}/relationships/messages', 'MessageController@store');
        });
    });
});