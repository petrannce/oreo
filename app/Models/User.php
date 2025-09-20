<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     // relationships
    public function receptionist() { return $this->hasOne(Receptionist::class); }
    public function doctor() { return $this->hasOne(Doctor::class); }
    public function patient() { return $this->hasOne(Patient::class); }

    // convenience: get profile for current role
    public function profileForRole()
    {
        if ($this->hasRole('doctor')) return $this->doctor;
        if ($this->hasRole('receptionist')) return $this->receptionist;
        if ($this->hasRole('patient')) return $this->patient;
        return null;
    }

}
