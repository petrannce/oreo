<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'speciality',
        'department',
        'employment_type',
        'description',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
