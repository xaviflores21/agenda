<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes(['register'=>true,'reset'=>true,'verify'=>true]);
Route::get('/','App\Http\Controllers\EventosController@index')->middleware('auth');
Route::get('/personas/{personas}','App\Http\Controllers\PersonasController@show')->middleware('auth');
Route::resource('eventos','App\Http\Controllers\EventosController')->middleware('auth');
Route::resource('personas','App\Http\Controllers\PersonasController')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
