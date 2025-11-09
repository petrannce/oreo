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

    public function items()
    {
        return $this->hasMany(BillingItem::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospitalService()
    {
        return $this->belongsTo(HospitalService::class, 'hospital_service_id');
    }

}
