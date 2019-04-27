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

Route::get('/', 'PersonController@index');
Route::post('/person/ajax_list', 'PersonController@ajax_list');
Route::post('/person/ajax_add', 'PersonController@add');
Route::get('/person/ajax_edit/{id}', 'PersonController@ajax_edit');
Route::put('/person/ajax_update', 'PersonController@ajax_update');
Route::get('/person/ajax_delete/{id}', 'PersonController@ajax_delete');
