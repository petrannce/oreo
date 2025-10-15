<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'form',
        'stock_quantity',
        'unit_price',
        'manufacture',
        'expiry_date',
    ];

    public function pharmacyOrderItems()
    {
        return $this->hasMany(PharmacyOrderItem::class);
    }
}
