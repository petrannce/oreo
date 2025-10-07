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
        'amount',
        'payment_method',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
