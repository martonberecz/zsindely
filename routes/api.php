<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//      
Route::get('roofs', 'RoofController@index');
Route::get('roof/{id}', 'RoofController@show');
Route::post('roof', 'RoofController@store');
Route::put('roof/{id}', 'RoofController@store');


Route::get('fields', 'FieldController@index');
Route::get('field/{id}', 'FieldController@show');
Route::post('field', 'FieldController@store');
Route::put('field/{id}', 'FieldController@store');

Route::get('kalks', 'KalkulacioController@index');
Route::get('kalk/{id}', 'KalkulacioController@show');
Route::post('kalk', 'KalkulacioController@store');
Route::put('kalk/{id}', 'KalkulacioController@store');

