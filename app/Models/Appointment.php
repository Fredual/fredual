<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class);
    }

    public function patient(){
        return $this->belongsTo(User::class);
    }

    public function getScheduledTime12Attribute(){
        return (new Carbon($this->sheduled_time))->format('g:i A');
    }
    
    public function turno()
    {
        return $this->hasOne(Turno::class);
    }
}
