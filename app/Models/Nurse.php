<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department',
        'employment_type',
        'license_number',
        'employee_code',
        'hire_date',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function triages()
    {
        return $this->hasMany(Triage::class);
    }

}
