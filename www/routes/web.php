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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'App\Http\Controllers\HomePage@index');
Route::get('/account', 'App\Http\Controllers\AccountPage@index');
Route::post('/auth-photo', 'App\Http\Controllers\Photo@auth');
Route::post('/save-photo', 'App\Http\Controllers\Photo@save');
