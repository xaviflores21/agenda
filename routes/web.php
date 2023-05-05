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


//ADMINROUTE
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Reporte
Route::middleware(['auth', 'esJefeDeArea'])->group(function () {
    Route::resource('reporte', 'App\Http\Controllers\reporteController');
    Route::resource('personas', 'App\Http\Controllers\PersonasController');
    Route::resource('reporteUsuarios', 'App\Http\Controllers\ReporteUsuariosController');
    Route::resource('usuariosTable', 'App\Http\Controllers\UsuarioControllerVista');
    Route::resource('reportePersona','App\Http\Controllers\ReporteControllerPersona');
    Route::resource('reporteHorario','App\Http\Controllers\ReporteHorarioController');
    Route::get('horariosMuestra', 'App\Http\Controllers\PersonasController@horariosIndex')->name('horarios');
    Route::post('horarios/addHorarios', [App\Http\Controllers\PersonasController::class, 'addHorario'])->name('horarios.add');
   
    Route::delete('/horarios/{id}', [App\Http\Controllers\PersonasController::class, 'destroyHorario'])->name('horarios.destroyHorario');
    Route::patch('/horarios/{horario_id}',[App\Http\Controllers\PersonasController::class, 'updateHorarios'])->name('horarios.updateHorarios');


});
Route::middleware(['auth', 'esJefeDeArea'])->group(function () {
    Route::resource('horarios', 'App\Http\Controllers\HorariosController');
});
Route::post('/reporte/enviar',  [App\Http\Controllers\reporteController::class, 'EnviarReporteInformacion'])->name('reporte.enviar');

Route::get('/personal/mostrarEventos', [App\Http\Controllers\PersonasController::class, 'mostrarEventos'])->name('personas.mostrarEventos');
