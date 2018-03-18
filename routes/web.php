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

Route::get('/{category?}', 'HomeController@index')->name('home');
Route::get('/search/{keyword}', 'SearchController@index')->name('search.index');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/users/{user}/safety', 'UsersController@safety')->name('users.safety');
Route::get('/users/{user}/notes', 'UsersController@notes')->name('users.notes');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::post('/users/{user}/attach', 'UsersController@attachOrDetach')->name('users.attach');
Route::get('/users/{user}/photo/{hash}?s={size}', 'UsersController@photo')->name('users.photo');

Route::resource('users', 'UsersController', ['except' => ['index']]);
Route::resource('notes', 'NotesController', ['only' => ['store', 'destroy', 'show']]);
Route::resource('letters', 'LettersController', ['only' => ['show', 'index']]);
Route::resource('messages', 'MessagesController', ['only' => ['show', 'update', 'destroy']]);

Route::get('/messages/{user}/{nav_type}', 'MessagesController@index')->name('messages.index');
