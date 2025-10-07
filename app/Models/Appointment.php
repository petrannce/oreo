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

    public function nurse() 
    { 
        return $this->belongsTo(Nurse::class); 
    }

    public function scopeVisibleToRole($query, $role)
{
    $permissions = [
        'receptionist' => ['reception', 'triage', 'cancelled'],
        'nurse' => ['triage', 'doctor_consult'],
        'doctor' => ['doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'],
        'lab_technician' => ['lab'],
        'pharmacist' => ['pharmacy', 'billing', 'completed'],
        'admin' => ['reception', 'triage', 'doctor_consult', 'lab', 'pharmacy', 'billing', 'completed', 'cancelled'],
    ];

    $allowedStages = $permissions[$role] ?? [];

    if ($role !== 'admin') {
        $query->whereIn('process_stage', $allowedStages);
    }

    return $query;
}

}
