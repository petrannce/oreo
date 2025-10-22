<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_order_id',
        'medicine_id',
        'quantity',
        'dosage',
        'unit_price',
        'subtotal',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pharmacyOrder()
    {
        return $this->belongsTo(PharmacyOrder::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

     public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Appointment::class,
            'id', // foreign key on appointments
            'id', // foreign key on patients
            'appointment_id', // local key on pharmacy_order_items
            'patient_id' // local key on appointments
        );
    }
}
