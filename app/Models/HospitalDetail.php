<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalDetail extends Model
{
    use HasFactory;

    protected $table = 'hospital_details';

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'website',
        'logo',
        'image',
    ];
}
