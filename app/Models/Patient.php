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
        'DOB',
        'phone',
        'gender',
        'age',
        'address',
    ];
}
