<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Horarios;
use App\Models\User;
use Illuminate\Support\Carbon;

class HorarioController extends Controller
{
    public function edit()
    {
        $days = [
            'Lunes', 'Martes', 'Miércoles', 'Jueves',
            'Viernes', 'Sabado', 'Domingo'
        ];

        $doctors = User::doctors()->get();

        $horarios = Horarios::where('user_id');

        return view('horario', compact('days', 'doctors'));
    }

    public function all(Request $request)
    {
        $id = $request->input('id');
        $horarios = Horarios::where('user_id', $id)->get();
        //$horarios = Horarios::all();


        return response(json_encode($horarios), 200)
            ->header('Content-type', 'text/plain');
    }

    public function store(Request $request)
    {

        $active = $request->input('active') ?: [];
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');
        $fechaActual = Carbon::now();

        for ($i = 0; $i < 7; $i++) {

            Horarios::updateOrCreate(
                [
                    'day' => $i,
                    'user_id' => $request->input('selectedValue')
                ],
                [
                    'active' => in_array($i, $active),
                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],
                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i],
                    'fecha_doctors' => $fechaActual,
                ]
            );
        }

        return back();
    }

    public function metodoQueDevuelveLaVista(Request $request){
        
        $days = [
            'Lunes', 'Martes', 'Miércoles', 'Jueves',
            'Viernes', 'Sabado', 'Domingo'
        ];

        $fecha = $request->input('fecha');
        $id = $request->input('id');

        $horarios = Horarios::where('user_id', $id)->get();

        return view('doctors.hors',compact('days', 'horarios'));
    }
}
