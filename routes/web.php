<?php

use Illuminate\Support\Facades\Route;

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
    if (Auth::check()) {
        return view('admin');
    }
    return redirect('/login');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


//Route::get('/users', 'UsersController@index');
Route::post('/users', 'UsersController@create');

Route::get('/{vue_capture?}', function () {
    return view('admin');
 })->where('vue_capture', '^(?!storage).*$'); 