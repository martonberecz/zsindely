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

//Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/roofcalculator', 'HomeController@calc');
Route::get('/articles', 'HomeController@articles');
Route::get('/contact', 'HomeController@contact');
Route::get('/article', 'HomeController@articleView');


Route::post('/', 'HomeController@sendOrder');
