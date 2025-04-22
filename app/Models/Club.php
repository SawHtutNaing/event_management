<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'founder_id', 'is_active'];

    public function founder()
    {
        return $this->belongsTo(User::class, 'founder_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function isMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function isAdmin(User $user)
    {
        return $this->members()
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->exists();
    }

    public function announcements()
{
    return $this->hasMany(Announcement::class)->latest();
}

public function pinnedAnnouncements()
{
    return $this->hasMany(Announcement::class)->where('is_pinned', true)->latest();
}



}
