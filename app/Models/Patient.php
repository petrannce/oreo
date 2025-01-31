<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = ['user_id', 'DOB', 'phone_number', 'gender', 'age', 'address', 'medical_history'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Each patient has a user account
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id'); // One-to-Many: Patient → Appointments
    }
}
