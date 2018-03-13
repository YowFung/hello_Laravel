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
})->name('home');

Route::get('/users/login', 'SessionsController@create')->name('users.login');
Route::post('/users/login', 'SessionsController@store')->name('users.login');
Route::delete('/users/logout', 'SessionsController@destroy')->name('users.logout');
Route::get('/users/password', 'UsersController@password')->name('users.password');
Route::patch('/users/password', 'UsersController@updatePassword')->name('users.password');

Route::resource('users', 'UsersController');

Route::get('/notes/show/{users}', 'NotesController@show')->name('notes.show');
Route::get('/fans/from/{users}', 'FansController@fromList')->name('fans.from');
Route::get('/fans/to/{users}', 'FansController@toList')->name('fans.to');

Route::get('/messages/show/{users}', 'MessagesController@show')->name('messages.show');

