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
Route::get('/', 'pagesController@home');
Route::get('/buyPages', 'pagesController@buyPages');

Route::post('/buyQueue', 'pagesController@buyQueue')->name('buyQueue');

Route::get('/order', 'pagesController@order');
Route::get('/chVali', 'pagesController@chVali');

Route::view('/login', 'login')->name('loginForm');
Route::POST('/login', 'signController@login')->name('loginProcess');

Route::view('/signup', 'signup')->name('signupForm');
Route::POST('/signup', 'signController@signup')->name('signupProcess');

Route::get('/logout', 'signController@logout');
