<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = ['patient_id', 'booked_by', 'date', 'time', 'service', 'doctor_id', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id'); // Appointment belongs to a Patient
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by'); // Who booked this appointment
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id'); // Assigned Doctor
    }
}
