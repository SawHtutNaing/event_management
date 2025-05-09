<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['club_id', 'user_id', 'title', 'content', 'is_pinned'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
