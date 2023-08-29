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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function(){
    
    //Rutas Especialidades
    //index
    Route::get('/especialidades', [App\Http\Controllers\Admin\SpecialtyController::class, 'index']);
    //Vista formulario crear
    Route::get('/especialidades/create', [App\Http\Controllers\Admin\SpecialtyController::class, 'create']);
    //Vista  formulario para editar
    Route::get('/especialidades/{specialty}/edit', [App\Http\Controllers\Admin\SpecialtyController::class, 'edit']);
    //Formulario de crear
    Route::post('/especialidades', [App\Http\Controllers\Admin\SpecialtyController::class, 'sendData']);
    //Peticion tipo put - para editar
    Route::put('/especialidades/{specialty}', [App\Http\Controllers\Admin\SpecialtyController::class, 'update']);
    //peticion para eliminar
    Route::delete('/especialidades/{specialty}', [App\Http\Controllers\Admin\SpecialtyController::class, 'destroy']);

    //Rutas Médicos
    Route::resource('medicos','App\Http\Controllers\Admin\DoctorController');

    //Rutas Pacientes
    Route::resource('pacientes','App\Http\Controllers\Admin\PatientController');

    //Rutas Para asignar horario a doctor (Ojo evaluar si dejar en admin o doctor)
    Route::get('/horario', [App\Http\Controllers\Doctor\HorarioController::class, 'edit']);
    //Formulario para guardar horarios
    Route::post('/horario', [App\Http\Controllers\Doctor\HorarioController::class, 'store']);

});

Route::middleware(['auth', 'doctor'])->group(function(){


});

