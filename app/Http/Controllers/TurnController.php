<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Turnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TurnController extends Controller
{
    public function index()
    {
        $turnos = Turnos::whereDate('fecha_turno', DB::raw('CURDATE()'))->where('statusT', 'pendiente')->paginate(10);
        //dd($citas);
        return view('turn.index', compact('turnos'));
    }

    public function callTurns($id)
    {
        // Aquí debes implementar la lógica para "llamar" el turno con el ID proporcionado.
        // Puedes actualizar el estado del turno, registrar la hora de llamada, etc.
        // Por ejemplo:
        $turno = Turnos::find($id);
        $turno->statusT = 'Llamado';
        $turno->hora_inicio = now(); // Registra la hora de la llamada
        $turno->save();

        // Puedes devolver una respuesta JSON o redirigir a una página, dependiendo de tus necesidades.
        return response()->json(['message' => 'Turno llamado exitosamente']);
    }

    public function turnosPublicos()
    {
        return view('turn.turnos-publicos');
    }

    public function getTurnoLlamado()
    {
        // Recupera el turno llamado más reciente desde la base de datos.
        $turnoLlamado = Turnos::where('statusT', 'Llamado')->orderBy('created_at', 'desc')->first();

        if ($turnoLlamado) {
            $nombrePaciente = $turnoLlamado->appointment->patient->name;
            $nombreModulo = $turnoLlamado->appointment->modulo;

            return response()->json([
                'turnoLlamado' => [
                    'id' => $turnoLlamado->id,
                    'nombrePaciente' => $nombrePaciente,
                    'nombreModulo' => $nombreModulo
                ]
            ]);
        } else {
            // Si no se encontró el turno, devuelve una respuesta vacía o un mensaje de error.
            return response()->json(['turno' => null]);
        }
    }

    public function atenderTurno($id)
    {
        // Encuentra el turno por su ID y cambia su estado a "Atendido"
        $turno = Turnos::find($id);
        $turno->statusT = 'Atendido';
        $turno->save();

        return response()->json(['message' => 'Turno atendido exitosamente']);
    }

    public function cerrarTurno($id)
    {
        $turno = Turnos::find($id);
        $turno->hora_fin = now();
        $turno->save();
    }
}
