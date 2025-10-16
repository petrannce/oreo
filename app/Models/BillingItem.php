<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id', 'hospital_service_id', 'description',
        'quantity', 'unit_price', 'subtotal',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }

    public function hospitalService()
    {
        return $this->belongsTo(HospitalService::class);
    }

}
