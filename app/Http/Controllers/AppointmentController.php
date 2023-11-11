<?php

namespace App\Http\Controllers;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Specialty;
use App\Models\Turnos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {

        $role = auth()->user()->role;

        if ($role == 'admin') {
            //admin
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada');
            $pendingAppointments = Appointment::all()->where('status', 'Reservada');
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada']);
        } elseif ($role == 'doctor') {
            //doctor
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada')->where('doctor_id', auth()->id());
            $pendingAppointments = Appointment::all()->where('status', 'Reservada')->where('doctor_id', auth()->id());
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada'])->where('doctor_id', auth()->id());
        } elseif ($role == 'paciente') {
            //pacientes
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada')->where('patient_id', auth()->id());
            $pendingAppointments = Appointment::all()->where('status', 'Reservada')->where('patient_id', auth()->id());
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada'])->where('patient_id', auth()->id());
        }

        return view('appointment.index', compact('confirmedAppointments', 'pendingAppointments', 'oldAppointments', 'role'));
    }

    public function create(HorarioServiceInterface $horarioServiceInterface)
    {

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
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $doctorId);
        } else {
            $intervals = null;
        }

        return view('appointment.create', compact('specialties', 'patients', 'doctors', 'intervals'));
    }
    public function store(Request $request, HorarioServiceInterface $horarioServiceInterface)
    {
        $citas = Appointment::all();
        $citasJson = $citas->toJson();
        $citasArray = json_decode($citasJson, true);
        //dd($citasArray);
        foreach ($citasArray as $cita) {
            $horass = date("H:i:s", strtotime($request['sheduled_time'][0]));
            if (($cita['scheduled_date'] == $request['scheduled_date']) && 
                ($cita['sheduled_time'] == $horass) &&
                $cita['modulo'] == $request['modulo']) {

                    $notification = 'El dia '.$request['scheduled_date'].' en la hora: '.$horass.' en el modulo '.$request['modulo'].' Ya existe una cita';
                    return redirect('/miscitas')->with(compact('notification'));
            }

        }
       
        
        $rules = [
            'sheduled_time' => 'required|array',
            'sheduled_time.*' => 'required',
            'type' => 'required',
            'modulo' => 'required',
            'doctor_id' => 'exists:users,id',
            'patient_id' => 'exists:users,id',
            'specialty_id' => 'exists:specialties,id',
        ];

        $messages = [
            'sheduled_time.required' => 'Debe seleccionar una hora válida para su cita',
            'sheduled_time.*.required' => 'Debe seleccionar una hora válida para su cita',
            'type.required' => 'Debe seleccionar el tipo de consulta',
            'modulo.required' => 'Debe seleccionar el módulo de la cita',
            'patient_id.exists' => 'Seleccione un paciente',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only([
            'scheduled_date',
            'type',
            'modulo',
            'observacion',
            'patient_id',
            'doctor_id',
            'specialty_id',
        ]);

        $sheduledTimes = $request->input('sheduled_time', []);

        foreach ($sheduledTimes as $sheduledTime) {
            $carbonTime = Carbon::createFromFormat('g:i A', $sheduledTime);
            $scheduledTime = $carbonTime->format('H:i:s');

            $registro = new Appointment();
            $registro->scheduled_date = $data['scheduled_date'];
            $registro->sheduled_time = $scheduledTime;
            $registro->type = $data['type'];
            $registro->modulo = $data['modulo'];
            $registro->observacion = $data['observacion'];
            $registro->patient_id = $data['patient_id'];
            $registro->doctor_id = $data['doctor_id'];
            $registro->specialty_id = $data['specialty_id'];

            // Validar si el horario está disponible antes de guardar
            if (!$horarioServiceInterface->isAvailableInterval($registro->scheduled_date, $registro->doctor_id, $carbonTime)) {
                $notification = 'La hora seleccionada ya se encuentra ocupada por otro paciente.';
                return redirect('/miscitas')->with(compact('notification'));
            }

            // Guarda el registro en la base de datos
            $registro->save();
        }

        $notification = 'Las citas se han programado correctamente.';
        return redirect('/miscitas')->with(compact('notification'));
    }



    public function cancel(Appointment $appointment)
    {

        $appointment->status = 'Cancelada';

        $appointment->save();

        $notification = 'La cita se ha cancelado correctamente.';

        return back()->with(compact('notification'));
    }

    public function confirm(Appointment $appointment)
    {
        //dd($appointment);
        $patient = User::findOrFail($appointment->patient_id);
        //dd($patient);
        $turno = New Turnos();
        
        if ($appointment) {
            $turno->nombre_paciente = $patient->name;
            $turno->modulo_turno = $appointment->modulo;
            $turno->fecha_turno = $appointment->scheduled_date;
            $turno->hora_inicio = Carbon::now()->format('H:i:s');
            $turno->hora_fin = $turno->hora_inicio;
            $turno->statusT = 'Pendiente';
            $turno->save();

            $appointment->status = 'Confirmada';
            $appointment->save();

        }

        $notification = 'La cita se ha confirmado correctamente.';

        return back()->with(compact('notification'));
    }
}
