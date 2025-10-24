<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'schedule_id',
        'user_id',
        'total_price',
        'booking_code',
        'status',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function seats(){
        return $this->belongsToMany(\App\Models\BusSeat::class, 'booking_seats', 'booking_id', 'bus_seat_id');
    }
}
