<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image',
        'slug',
    ];

    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class);
    }
    
}
