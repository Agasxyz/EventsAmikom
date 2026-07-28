<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'organizer_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizer_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

        public function reviews()
        {
            return $this->hasMany(Review::class);
        }

        /**
         * Rata-rata rating event (null jika belum ada review).
         */
        public function averageRating(): ?float
        {
            $avg = $this->reviews()->avg('rating');
            return $avg ? round($avg, 1) : null;
        }

        /**
         * Total jumlah review.
         */
        public function reviewCount(): int
        {
            return $this->reviews()->count();
        }

}
