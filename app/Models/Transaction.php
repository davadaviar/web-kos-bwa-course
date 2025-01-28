<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [

        'code',
        'boarding_house_id',
        'room_id',
        'name',
        'email',
        'phone_number',
        'payment_method',
        'payment_status',
        'start_date',
        'duration',
        'total_amount',
        'transaction_date',
        'snap_token',

    ];

    protected $cast = [
        'start_date' => 'date'
    ];

    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
