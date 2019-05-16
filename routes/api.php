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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');


    Route::get('users', 'AuthController@users');
    Route::delete('delete/{id}', 'AuthController@delete');
    Route::get('getById/{id}', 'AuthController@getById');
    Route::put('update/{id}', 'AuthController@update');

    Route::group(['middleware' => 'auth:api'], function () {
        /*Route::get('user', 'AuthController@user');*/
        Route::get('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
        Route::post('user_rol', 'AuthController@user_rol');
    });
});

Route::prefix('role')->group(function () {
    Route::get('all', 'RolesController@index');
    Route::post('create', 'RolesController@create');
    Route::get('getById/{id}', 'RolesController@getById');
    Route::delete('delete/{id}', 'RolesController@delete');
    Route::put('update/{id}', 'RolesController@update');
});

Route::prefix('store')->group(function () {
    Route::get('all/{user_id}/{rol_name}', 'StoresController@index');
    Route::get('all', 'StoresController@all');
    Route::post('create', 'StoresController@create');
    Route::get('getById/{id}', 'StoresController@getById');
    Route::delete('delete/{id}', 'StoresController@delete');
    Route::put('update/{id}', 'StoresController@update');
});
