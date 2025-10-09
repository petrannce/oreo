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

/*************  ✨ Windsurf Command ⭐  *************/
/*******  7c397e54-2569-4acc-9ae6-f296642b16d0  *******/
    public function triages()
    {
        return $this->hasMany(Triage::class);
    }

}
