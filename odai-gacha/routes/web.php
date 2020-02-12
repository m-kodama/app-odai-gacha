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
    return view('index');
});
Route::get('/gacha', 'GachaController@index');
Route::get('/gacha/{gachaId}/edit', 'GachaController@edit');
Route::get('/gacha/create', 'GachaController@create');
Route::post('/gacha', 'GachaController@createGachaDetail');
Route::put('/gacha/{gachaId}', 'GachaController@updateGacha');
Route::delete('/gacha/{gachaId}', 'GachaController@deleteGacha');
Route::get('/gacha/{gachaId}/machine', 'GachaController@getMachine');