<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'scheduled_date',
        'sheduled_time',
        'type',
        'modulo',
        'observacion',
        'patient_id',
        'doctor_id',
        'specialty_id'

    ];
}
