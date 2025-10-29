<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $table = 'lab_tests';
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'lab_technician_id',
        'appointment_id',
        'test_name',
        'results',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function lab_technician()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function labService()
    {
        return $this->belongsTo(LabService::class, foreignKey: 'lab_service_id');
    }
}
