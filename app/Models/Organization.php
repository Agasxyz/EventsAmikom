<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo_path',
        'email',
        'phone',
        'status', // pending, active, suspended
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Get all reviews for the organization's events.
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Event::class, 'organizer_id', 'event_id');
    }

    /**
     * Calculate the average rating of the organizer.
     */
    public function averageRating(): ?float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    /**
     * Get the total review count.
     */
    public function reviewCount(): int
    {
        return $this->reviews()->count();
    }
}
