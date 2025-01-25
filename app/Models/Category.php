<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    
    use HasFactory, SoftDeletes;

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
