<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    public function booking()
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_seats',
            'booking_id',
            'bus_seat_id'
        );
    }
}
