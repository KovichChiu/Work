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

Route::get('/', 'home');

Route::get('/orderList', 'orderList')->middleware('verifyLogIn');
Route::get('/orderQueue/{id}', 'orderQueue')->middleware('VerifyTicket');

Route::get('/order', 'orderShow')->middleware('verifyLogIn');

//Route::get('/CheckVerify', 'pagesController@chVali');

Route::view('/login', 'login');
Route::POST('/login', 'UserController@login');

Route::POST('/cli', 'socketController@soc_Cli');

Route::view('/signup', 'signup');
Route::POST('/signup', 'UserController@signup');

Route::get('/logout', 'UserController@logout');


