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
    return view('Auth/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Mostrar turnos
Route::get('/turnos-publicos', [App\Http\Controllers\TurnController::class, 'turnosPublicos']);

Auth::routes();


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
    //jquery
    //Route::post('/horario', [App\Http\Controllers\Doctor\HorarioController::class, 'all']);
    //horario
    Route::post('/horario/view', [App\Http\Controllers\Doctor\HorarioController::class, 'metodoQueDevuelveLaVista'])->name('horario.view');
    //Reservar Citas
    Route::get('/reservarcitas/create', [App\Http\Controllers\AppointmentController::class, 'create']);
    //Guardar citas
    Route::post('/reservarcitas', [App\Http\Controllers\AppointmentController::class, 'store']);
    

    //JSON
    Route::get('/especialidades/{specialty}/medicos', [App\Http\Controllers\Api\SpecialtyController::class, 'doctors']);
    Route::get('/intervalos/horas', [App\Http\Controllers\Api\HorarioController::class, 'hours']);

    //Nombre de paciente y doctor
    Route::get('/citas/nombres/{id}', [App\Http\Controllers\HomeController::class, 'buscarNombrePorId'])->name('citas.nombres');
    //turnos
    Route::get('/turnos', [App\Http\Controllers\TurnController::class, 'index'])->name('citas.actualizar');
    //Llamar
    Route::post('/llamar-turno/{id}', [App\Http\Controllers\TurnController::class, 'callTurns']);
    //cerrar
    Route::post('/cerrar-turno/{id}', [App\Http\Controllers\TurnController::class, 'cerrarTurno']);
    //Actualizar Turnos
    Route::get('/turno-llamado', [App\Http\Controllers\TurnController::class, 'getTurnoLlamado']);
    Route::post('/atender-turno/{id}', [App\Http\Controllers\TurnController::class, 'atenderTurno']);



});

Route::middleware(['auth'])->group(function(){

    //consulta de citas
    Route::get('/miscitas', [App\Http\Controllers\AppointmentController::class, 'index']);
    //Cancelar cita
    Route::post('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel']);
    //Confirmar Cita
    Route::post('/miscitas/{appointment}/confirm', [App\Http\Controllers\AppointmentController::class, 'confirm']);

});

