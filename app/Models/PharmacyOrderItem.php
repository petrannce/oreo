<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_order_id',
        'drug_name',
        'quantity',
        'dosage',
    ];

    public function pharmacyOrder()
    {
        return $this->belongsTo(PharmacyOrder::class);
    }
}
