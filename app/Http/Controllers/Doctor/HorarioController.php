<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Horarios;
use App\Models\User;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;


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
        $fecha = $request->input('fecha_doctors');
        $id = $request->input('user_id');
        $active = $request->input('active', []); // Usamos un valor predeterminado de un array vacío para asegurarnos de que siempre tengamos un array para iterar


        for ($i = 0; $i < 3; $i++) {

            $isActive = isset($active[$i]) && $active[$i] == 1 ? 1 : 0;

            Horarios::updateOrCreate(
                [
                    'fecha_doctors' => $fecha,
                    'user_id' => $id
                ],
                [
                    'active' => $isActive,
                    'morning_start' => $morning_start[$i],
                    'morning_end' => $morning_end[$i],
                    'afternoon_start' => $afternoon_start[$i],
                    'afternoon_end' => $afternoon_end[$i],

                ]
            );
        }

        return back();
    }

    public function metodoQueDevuelveLaVista(Request $request)
    {

        $id = $request->input('id');
        $fechaInicio = Carbon::parse($request->input('inicio'));
        $fechaFin = Carbon::parse($request->input('fin'));

        // Calcular la diferencia en días
        $diferenciaDias = $fechaInicio->diffInDays($fechaFin);
        $diferenciaDias += 1;
        // Crea un período de fechas entre la fecha de inicio y la fecha de fin, incluyendo ambas fechas.
        $period = CarbonPeriod::create($fechaInicio, $fechaFin);
        // Inicializa un array para almacenar las fechas.
        $fechasEnRango = [];

        // Itera sobre el período y agrega cada fecha al array.
        foreach ($period as $fecha) {
            $fechasEnRango[] = $fecha->toDateString(); // Puedes cambiar el formato si lo necesitas.
        }

       /*  info('Datos de la solicitud:', ['Rango de fechas' => $fechasEnRango]);
        info('Datos de la solicitud:', ['id' => $id]);
        info('Datos de la solicitud:', ['fecha inicio' => $fechaInicio]);
        info('Datos de la solicitud:', ['fecha fin' => $fechaFin]);
        info('Diferencia en días:', ['diferencia' => $diferenciaDias]); */

        $horarios = Horarios::where('user_id', $id)->whereBetween('fecha_doctors', [$fechaInicio, $fechaFin])->get();

        info('Diferencia en días:', ['diferencia' => $horarios]);

        return view('doctors.hors', compact('horarios'));
    }
}
