<?php

use Illuminate\Http\Request;
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
    return redirect('/gacha');
});
Route::prefix('gacha')->group(function () {
    Route::get('/', 'GachaController@index');
    Route::get('/{gachaId}/machine', 'GachaController@getMachine');
    Route::get('/create', 'GachaController@create');
    Route::get('/{gachaId}/edit', 'GachaController@edit');
    Route::post('/', 'GachaController@createGachaDetail');
    Route::put('/{gachaId}', 'GachaController@updateGacha');
    Route::delete('/{gachaId}', 'GachaController@deleteGacha');
});
Route::prefix('api/gacha')->group(function () {
    Route::post('/{gachaId}/auth', 'GachaController@auth');
    Route::get('/', 'GachaController@index');
});