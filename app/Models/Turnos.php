<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    use HasFactory;

    // En el modelo de Turno
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'cita_id');
    }
}
