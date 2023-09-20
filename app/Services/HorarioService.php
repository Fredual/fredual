<?php 

namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface {

    public function getAvailableIntervals($date, $doctorId){
        
        $horario = Horarios::where('active', true)
        ->where('fecha_doctors', $date)
        ->where('user_id', $doctorId)
        ->first([
            'morning_start','morning_end',
            'afternoon_start', 'afternoon_end'
        ]);

        if (!$horario) {
            return [];
        }

        $morningIntervalos = $this->getIntervalos(
            $horario->morning_start, $horario->morning_end, $doctorId, $date
        );

        $afternoonIntervalos = $this->getIntervalos(
            $horario->afternoon_start, $horario->afternoon_end, $doctorId, $date
        );

        $data = [];

        $data['morning'] = $morningIntervalos;
        $data['afternoon'] = $afternoonIntervalos;

        //dd($data);

        return response()->json(['data'=>$data]);
    }

    private function getIntervalos($start, $end , $doctorId, $date){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervalos = [];

        while ($start < $end) {
            $intervalo = [];
            $intervalo['start'] = $start->format('g:i A');

            $exists = Appointment::where('doctor_id',$doctorId)
                ->where('scheduled_date', $date)
                ->where('sheduled_time',$start->format('H:i:s'))
                ->exists();

            $start->addMinutes(20);
            $intervalo['end'] = $start->format('g:i A');

            if (!$exists) {
                $intervalos []= $intervalo;
            }
        }

        return $intervalos;
    }

}


?>