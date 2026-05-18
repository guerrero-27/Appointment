<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillabel = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->whereDate('date', '>=', today());
    }

    public function getFormattedTimeAttribute(): string
    {
        return date('h:i A', strtotime($this->start_time)). ' - ' . date('h:i A', strtotime($this->end_time));
    }
}
