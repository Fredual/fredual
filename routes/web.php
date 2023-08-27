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

//Rutas Especialidades
//index
Route::get('/especialidades', [App\Http\Controllers\SpecialtyController::class, 'index']);
//Vista formulario crear
Route::get('/especialidades/create', [App\Http\Controllers\SpecialtyController::class, 'create']);
//Vista  formulario para editar
Route::get('/especialidades/{specialty}/edit', [App\Http\Controllers\SpecialtyController::class, 'edit']);
//Formulario de crear
Route::post('/especialidades', [App\Http\Controllers\SpecialtyController::class, 'sendData']);
//Peticion tipo put - para editar
Route::put('/especialidades/{specialty}', [App\Http\Controllers\SpecialtyController::class, 'update']);
//peticion para eliminar
Route::delete('/especialidades/{specialty}', [App\Http\Controllers\SpecialtyController::class, 'destroy']);

//Rutas Médicos

Route::resource('medicos','App\Http\Controllers\DoctorController');


//Rutas Pacientes

Route::resource('pacientes','App\Http\Controllers\PatientController');
