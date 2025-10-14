<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'billable_type',
        'billable_id',
        'hospital_service_id',
        'amount',
        'payment_method',
        'status',
    ];

    public function billable()
    {
        return $this->morphTo();
    }

    public function medicalRecords()
    {
        return $this->hasMany(Medical::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function consultations()
    {
        return $this->hasMany(Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(BillingItem::class);
    }

}
