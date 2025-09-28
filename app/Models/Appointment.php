<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'booked_by',
        'date',
        'time',
        'status'
    ];

    public function patient() 
    { 
        return $this->belongsTo(User::class,'patient_id'); 
    }
    public function doctor()  
    { 
        return $this->belongsTo(User::class,'doctor_id'); 
    }

    public function bookedBy() 
    { 
        return $this->belongsTo(User::class,'booked_by'); 
    }

    public function service() 
    { 
        return $this->belongsTo(Service::class,'service_id'); 
    }

}
