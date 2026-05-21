<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event; 

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // 1 kategori punya banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}