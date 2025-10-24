<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    // Nama tabel
    protected $table = 'bus_seats';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'bus_id',
        'seat_number',
        'is_available',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_seats', 'bus_seat_id', 'booking_id');
    }
}
