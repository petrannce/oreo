<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'department',
        'speciality',
        'employment_type',
        'license_number',
        'bio',
    ];

    

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

}
