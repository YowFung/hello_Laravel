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

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/users/{user}/safety', 'UsersController@safety')->name('users.safety');
Route::get('/users/{user}/notes', 'UsersController@notes')->name('users.notes');
Route::get('/users/{user}/attentions', 'UsersController@attentions')->name('users.attentions');
Route::get('/users/{user}/messages', 'UsersController@messages')->name('users.messages');

Route::resource('users', 'UsersController');

Route::resource('notes', 'NotesController', ['only' => ['store', 'destroy']]);

Route::get('/fans/to/{users}', 'FansController@toList')->name('fans.to');
Route::post('/fans/focus/{user}', 'FansController@focusOn')->name('fans.focus');
