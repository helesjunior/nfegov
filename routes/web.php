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
    return view('welcome');
});

Route::get('decode', '\App\Http\Controllers\TesteController@decode');
Route::get('consulta', '\App\Http\Controllers\TesteController@consulta');
Route::get('status', '\App\Http\Controllers\TesteController@status');
Route::get('pdf', '\App\Http\Controllers\TesteController@teste');
