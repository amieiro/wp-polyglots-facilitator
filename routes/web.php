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

Route::get('/locale/change', 'HomeController@localeChange');
Route::get('/locale/{id}', 'HomeController@language');
Route::get('/', 'HomeController@index');
Route::post('/', 'TranslationController@downloadAndReplace');
