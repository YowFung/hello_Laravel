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

Route::get('/', function () {
    return view('home');
});

Route::get('/users/login', 'SessionsController@create')->name('users.login');
Route::post('/users/login', 'SessionsController@store')->name('users.login');
Route::delete('/users/logout', 'SessionsController@destroy')->name('users.logout');

Route::resource('users', 'UsersController');
