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


Route::get('/role', function () {
    return view('role.index');
});

Route::get('/', function () {
    return view('index');
});

Route::get('/stores', function () {
    return view('store.index');
});

Route::get('/users', function () {
    return view('user.index');
});

Route::get('/employees', function () {
    return view('employee.index');
});

Route::get('/weekpanel', function () {
    return view('weekpanel.index');
});

Route::get('/masteroverview', function () {
    return view('masteroverview.index');
});

Route::get('/schedule_col', function () {
    return view('schedule_col.index');
});

Route::get('/masteroverview_col', function () {
    return view('masteroverview_col.index');
});
/*Route::get('/', function () {
    return view('login');
});*/


