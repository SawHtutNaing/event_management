<?php
namespace App\Models;

// ...
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ...

    protected $guarded = [];
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function clubs()
{
    return $this->belongsToMany(Club::class)
        ->withPivot('role')
        ->withTimestamps();
}

public function foundedClubs()
{
    return $this->hasMany(Club::class, 'founder_id');
}

public function batches()
{
    return $this->belongsToMany(Batch::class);
}




}
