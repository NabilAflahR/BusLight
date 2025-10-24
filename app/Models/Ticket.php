<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'bus_seat_id',
        'price',
        'status',
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi ke kursi bus
    public function seat()
    {
        return $this->belongsTo(BusSeat::class, 'bus_seat_id');
    }
}
