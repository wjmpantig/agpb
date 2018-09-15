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
    return redirect()->route('gallery');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/privacy-policy', 'PublicController@privacy')->name('privacy');
Route::get('/generate','MediaController@generate')->name('generate');
Route::get('/gallery', 'MediaController@get')->name('gallery');
Route::get('/gallery/view/{id}', 'MediaController@get')->name('media');
Route::get('/profiles', 'ProfileController@get')->name('profiles');
