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


Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/users/{user}/safety', 'UsersController@safety')->name('users.safety');
Route::get('/users/{user}/notes', 'UsersController@notes')->name('users.notes');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::post('/users/{user}/attach', 'UsersController@attachOrDetach')->name('users.attach');
Route::patch('/users/{user}/updateAvatar', 'UsersController@updateAvatar')->name('users.updateAvatar');

Route::resource('users', 'UsersController', ['except' => ['index']]);
Route::resource('notes', 'NotesController', ['only' => ['store', 'destroy', 'show']]);
Route::resource('messages', 'MessagesController', ['only' => ['index', 'show', 'update', 'destroy']]);
Route::resource('comments', 'CommentsController', ['only' => ['store', 'destroy']]);
Route::resource('letters', 'LettersController', ['only' => ['create', 'store']]);
Route::resource('search', 'SearchController', ['only' => 'index']);

Route::get('/{category?}', 'HomeController@index')->name('home');
Route::post('/back', 'HomeController@back')->name('back');