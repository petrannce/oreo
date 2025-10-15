<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'medical_record_id',
        'status',
    ];

    // relationships

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointmment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function medical_record()
    {
        return $this->belongsTo(Medical::class, 'medical_record_id');
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

    public function items()
    {
        return $this->hasMany(PharmacyOrderItem::class);
    }


}
