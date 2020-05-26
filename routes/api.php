<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('cliente', 'SingleControllerAPI@getClients');
Route::get('cliente/count', 'SingleControllerAPI@getNumClients');
Route::delete('cliente/{id}', 'SingleControllerAPI@deleteCliente');
Route::get('cliente/{id}', 'SingleControllerAPI@getClientByParkNum');
Route::get('cliente/matriculas/{id}', 'SingleControllerAPI@getNMatrPark');
Route::get('parque/livres/{id}', 'SingleControllerAPI@freeSpotsPark');
Route::get('matricula', 'SingleControllerAPI@getMatriculas');
Route::get('matricula/{park}', 'SingleControllerAPI@getMatriculasPark');
Route::delete('matricula/{id}', 'SingleControllerAPI@deleteMatricula');
Route::delete('qrcode/{id}', 'SingleControllerAPI@deleteQRcode');
Route::get('qrcodes/{park}', 'SingleControllerAPI@getQRPark');
Route::get('logs', 'SingleControllerAPI@getLogs');
Route::get('logs/{park}', 'SingleControllerAPI@getLogsPark');
Route::get('profile', 'SingleControllerAPI@profile');
Route::get('users', 'UsersController@index');
Route::delete('users/{id}', 'SingleControllerAPI@deleteUser');
Route::get('user/count', 'SingleControllerAPI@getNumUsers');
Route::post('cliente/add', 'SingleControllerAPI@createClient');
Route::post('addLog', 'SingleControllerAPI@addLog');
Route::post('matricula/add', 'SingleControllerAPI@addMatricula');
Route::post('cliente/updatelivres', 'SingleControllerAPI@updatelivres');
Route::post('cliente/updatemax', 'SingleControllerAPI@updatemax');
Route::post('file/upload', 'SingleControllerAPI@importMatricula');
Route::post('arduino/update', 'SingleControllerAPI@changeOccupied');
Route::post('estado/update', 'SingleControllerAPI@usoButoes');
Route::get('estado/coluna/{id}', 'SingleControllerAPI@getColunaState');
Route::post('qrcode/add', 'SingleControllerAPI@addQRcode');