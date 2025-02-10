<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use HasFactory;

    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'record_date',
        'diagnosis',
        'prescription',
        'notes'
    ];
}
