<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    use HasFactory;

    protected $table = 'receptionists';

    protected $fillable = ['user_id','employee_code','department','hire_date'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
}
