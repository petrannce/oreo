<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone_number',
        'date',
        'time',
        'service',
        'doctor',
        'status',
    ];
}
