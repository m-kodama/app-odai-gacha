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
// TODO グループ機能を使用する
Route::get('/gacha', 'GachaController@index');
Route::get('/gacha/{gachaId}/edit', 'GachaController@edit');
Route::get('/gacha/create', 'GachaController@create');
Route::post('/gacha', 'GachaController@createGachaDetail');
Route::put('/gacha/{gachaId}', 'GachaController@updateGacha');
Route::delete('/gacha/{gachaId}', 'GachaController@deleteGacha');
Route::get('/gacha/{gachaId}/machine', 'GachaController@getMachine');
// TODO api系　別ファイルに分ける
Route::post('/gacha/{gachaId}/auth', 'GachaController@auth');
Route::get('/api/gacha/', 'GachaController@get');