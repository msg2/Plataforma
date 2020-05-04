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
Route::get('matricula', 'SingleControllerAPI@getMatriculas');
Route::get('logs', 'SingleControllerAPI@getLogs');
Route::get('profile', 'SingleControllerAPI@profile');
Route::get('users', 'UsersController@index');
Route::post('cliente/add', 'SingleControllerAPI@createClient');
Route::post('matricula/addLog', 'SingleControllerAPI@addLogMatricula');
Route::post('matricula/add', 'SingleControllerAPI@addMatricula');
Route::post('cliente/updatelivres', 'SingleControllerAPI@updatelivres');
Route::post('cliente/updatemax', 'SingleControllerAPI@updatemax');