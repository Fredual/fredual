<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TurnController extends Controller
{
    public function index()
    {
        $citas = Appointment::whereDate('scheduled_date', DB::raw('CURDATE()'))->where('status', 'Confirmada')->paginate(10);
        //dd($citasDelDia);
        return view('turn.index',compact('citas'));
    }

    public function callTurns(Request $request,Appointment $cita)
    {
        $cita = Appointment::find($request->input('cita_id'));
        if ($cita) {
            $cita->status = 'Atendido';
            $cita->save();
        }

    }

    public function indexPublic()
    {
        // Lógica para obtener y mostrar los turnos públicos
        return view('turn.turnos-publicos');
    }
}
