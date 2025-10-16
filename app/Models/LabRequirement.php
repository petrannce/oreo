<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'name',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
