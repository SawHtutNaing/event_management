<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        // 'price',
        'image',
        'is_approved',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availableSeat()
    {
        return $this->capacity - 1;
    }

    public function club()
{
    return $this->belongsTo(Club::class);
}

public function scopeClubEvents($query, $clubId)
{
    return $query->where('club_id', $clubId);
}

public function batches()
{
    return $this->belongsToMany(Batch::class);
}

public function students()
{
    return $this->belongsToMany(User::class, 'event_students');


}
}
