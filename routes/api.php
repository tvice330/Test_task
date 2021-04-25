<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth',
], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('login', 'AuthController@loginUser');
    });
    Route::group(['prefix' => 'client'], function () {
        Route::post('login', 'AuthController@loginClient');
        Route::post('code', 'AuthController@phoneCode');
    });
    Route::post('logout', 'AuthController@logout')->middleware('auth:api');
});
