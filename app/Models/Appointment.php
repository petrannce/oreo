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
        return $this->hasMany(LabTest::class, 'appointment_id');
    }

    public function triage()
    {
        return $this->hasOne(Triage::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(Medical::class);
    }

    public function pharmacyOrder()
    {
        return $this->hasOne(PharmacyOrder::class);
    }


    public function billing()
    {
        return $this->morphOne(\App\Models\Billing::class, 'billable');
    }


    public function labStatus($id)
    {
        $appointment = Appointment::with('labTest')->findOrFail($id);

        return response()->json([
            'results_filled' => $appointment->labTest?->results_filled ?? false,
        ]);
    }

    public function labRequirements()
    {
        return $this->hasMany(LabRequirement::class);
    }

    protected $casts = [
        'date' => 'date:Y-m-d',  // Automatically cast to Carbon
        'time' => 'datetime:H:i',
    ];




}
