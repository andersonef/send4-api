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

Route::resource('/contatos', 'ContatosController', ['only' => ['store', 'index', 'update', 'destroy']]);
Route::resource('/mensagens', 'MensagensController', ['only' => ['store', 'show', 'update', 'destroy']]);