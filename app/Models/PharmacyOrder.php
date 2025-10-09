<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medical_record_id',
        'status',
    ];

    // relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function pharmacyOrder()
    {
        // Appointment → Medical → Pharmacy
        return $this->hasOneThrough(
            PharmacyOrder::class,
            Medical::class,
            'appointment_id',   // Foreign key on medical_records table
            'medical_record_id',// Foreign key on pharmacy_orders table
            'id',               // Local key on appointments table
            'id'                // Local key on medical_records table
        );
    }

}
