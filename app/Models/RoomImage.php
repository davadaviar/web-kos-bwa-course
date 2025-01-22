<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $fillable = [

        'room_id',
        'image',

    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
}
