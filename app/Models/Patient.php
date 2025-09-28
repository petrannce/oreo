<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'medical_record_number',
        'dob'
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function profile()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id'); // One-to-Many: Patient → Appointments
    }


}
