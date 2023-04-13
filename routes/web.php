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
Route::resource('eventos','App\Http\Controllers\EventosController')->middleware('auth');

Route::get('/personas', [App\Http\Controllers\PersonasController::class, 'index'])->middleware('auth');
Route::post('/personas/addName', [App\Http\Controllers\PersonasController::class, 'addName'])->name('personas.addName');
//Con estos controladores manejo donde se sua la apgina con personas
Route::resource('/','App\Http\Controllers\PersonasController')->middleware('auth');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
