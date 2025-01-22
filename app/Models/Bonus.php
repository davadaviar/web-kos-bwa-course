<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [

        'boarding_house_id',
        'name',
        'description',

    ];

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }
    
}
