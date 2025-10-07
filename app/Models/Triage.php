<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triage extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'nurse_id',
        'temperature',
        'heart_rate',
        'blood_pressure',
        'weight',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
