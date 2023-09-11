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

        //dd($request->all());

        $fechas = $request->input('fechas_doctors');
        $userIds = $request->input('user_id');
        $actives = $request->input('active');
        $morningStarts = $request->input('morning_start');
        $morningEnds = $request->input('morning_end');
        $afternoonStarts = $request->input('afternoon_start');
        $afternoonEnds = $request->input('afternoon_end');

        //dd($fechas,$userIds,$actives,$morningStarts,$morningEnds,$afternoonStarts,$afternoonEnds);
        
        foreach ($fechas as $key => $fecha) {
            info($fecha);
        
            Horarios::updateOrCreate(
                [
                    'user_id' => $userIds[$key],
                    'fecha_doctors' => $fecha,
                ],
                [
                    'active' => $actives[$key],
                    'morning_start' => $morningStarts[$key],
                    'morning_end' => $morningEnds[$key],
                    'afternoon_start' => $afternoonStarts[$key],
                    'afternoon_end' => $afternoonEnds[$key],
                    'day' => 0,
                ]
            );
        }

        return back()->with('success', 'Los datos se han guardado exitosamente.');
    }

    public function metodoQueDevuelveLaVista(Request $request)
    {
        $id = $request->input('id');
        $fechaInicio = Carbon::parse($request->input('inicio'));
        $fechaFin = Carbon::parse($request->input('fin'));

        // Crea un período de fechas entre la fecha de inicio y la fecha de fin, incluyendo ambas fechas.
        $period = CarbonPeriod::create($fechaInicio, $fechaFin);

        $diferenciaDias = $fechaInicio->diffInDays($fechaFin);
        $diferenciaDias += 1;

        // Obtén todos los horarios dentro del rango de fechas en una sola consulta.
        $horarios = Horarios::where('user_id', $id)->whereBetween('fecha_doctors', [$fechaInicio, $fechaFin])->get();

        // Inicializa un array para almacenar las fechas y su información.
        $fechasConInformacion = [];

        // Itera sobre el período de fechas y procesa los horarios.
        foreach ($period as $fecha) {
            $fechaFormateada = $fecha->toDateString();
            $fechasConInformacion[$fechaFormateada]['tieneInformacion'] = false;
            $fechasConInformacion[$fechaFormateada]['horarios'] = [];

            foreach ($horarios as $horario) {
                if ($horario->fecha_doctors == $fechaFormateada) {
                    $fechasConInformacion[$fechaFormateada]['tieneInformacion'] = true;
                    $fechasConInformacion[$fechaFormateada]['horarios'][] = $horario;
                }
            }
        }
        //info('fechasConInformacion:', $fechasConInformacion);

        return view('doctors.hors', compact('fechasConInformacion', 'id', 'diferenciaDias'));
    }
}
