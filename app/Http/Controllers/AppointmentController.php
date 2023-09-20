<?php

namespace App\Http\Controllers;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(HorarioServiceInterface $horarioServiceInterface){

        $specialties = Specialty::all();
        $patients = User::patients()->get();

        $specialtyId = old('specialty_id');

        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');

        if ($date && $doctorId) {
            $intervals = $horarioServiceInterface->getAvailableIntervals($date,$doctorId);
        }else{
            $intervals = null;
        }

        return view('appointment.create',compact('specialties','patients','doctors','intervals'));
    }

    public function store(Request $request){
        //dd($request);
        $rules = [
            'sheduled_time' => 'required',
            'type' => 'required',
            'modulo' => 'required',
            'doctor_id' => 'exists:users,id',
            'patient_id' => 'exists:users,id',
            'specialty_id' => 'exists:specialties,id'
        ];

        $message = [
            'sheduled_time.required' => ' Debe seleccionar una hora válida para su cita',
            'type.required' => ' Debe seleccionar el tipo de consulta',
            'modulo.required' => ' Debe selecionar el modulo de la cita',
            'patient_id.exists' => ' Seleccione un paciente'
         ];


        $this->validate($request, $rules, $message);

        $data = $request->only([

            'scheduled_date',
            'sheduled_time',
            'type',
            'modulo',
            'observacion',
            'patient_id',
            'doctor_id',
            'specialty_id'
        ]);

        $sheduledTimes = $request->input('sheduled_time', []);


        foreach ($sheduledTimes as $sheduledTime) {

            $carbonTime = Carbon::createFromFormat('g:iA', $sheduledTime);
   
            $sheduledTime = $carbonTime->format('H:i:s');
            
            $registro = new Appointment();
            $registro->scheduled_date = $data['scheduled_date'];
            $registro->sheduled_time = $sheduledTime;
            $registro->type = $data['type'];
            $registro->modulo = $data['modulo'];
            $registro->observacion = $data['observacion'];
            $registro->patient_id = $data['patient_id'];
            $registro->doctor_id = $data['doctor_id'];
            $registro->specialty_id = $data['specialty_id'];
    
            // Guarda el registro en la base de datos
            $registro->save();
        }

        $notification = 'La cita se ha realizado correctamente.';

        return back()->with(compact('notification'));
    }
}
