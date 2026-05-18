<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function services()
    {
        return $this->hasMany(\App\Models\Service::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(\App\Models\TimeSlot::class);
    }

    public function appointmentsAsClient()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'client_id');
    }

    public function appointmentsAsAdmin()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'admin_id');
    }
}