<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
            'fname',
            'lname',
            'email',
            'phone_number',
            'address',
            'city',
            'country',
            'gender',
            'dob'
        ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id'); // One-to-Many: Patient → Appointments
    }
}
