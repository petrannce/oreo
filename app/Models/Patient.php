<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'medical_record_number', 'fname', 'lname', 'email',
        'phone_number', 'gender', 'dob', 'national_id',
        'country', 'city', 'address',
        'emergency_contact_name', 'emergency_contact_phone',
        'relationship_to_patient', 'created_by'
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
