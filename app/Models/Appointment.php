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
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function lab_technician()
    {
        return $this->belongsTo(LabTechnician::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function triage()
    {
        return $this->hasOne(Triage::class);
    }

    public function labTest()
    {
        return $this->hasOne(LabTest::class);
    }

    public function medicalRecord()
{
    return $this->hasOne(Medical::class);
}

    public function pharmacyOrder()
{
    return $this->hasOneThrough(
        PharmacyOrder::class,
        Medical::class,
        'appointment_id',  // Foreign key on medical_records
        'medical_record_id',  // Foreign key on pharmacy_orders
        'id',  // Local key on appointments
        'id'   // Local key on medical_records
    );
}

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }



}
