<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTechnician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department',
        'employee_type',
        'license_number',
        'employee_code',
        'hire_date',
        'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
