<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $table = 'buses';

    protected $fillable = [
        'license_plate',
        'model',
        'capacity',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function seats()
    {
        return $this->hasMany(BusSeat::class, 'bus_id')->orderBy('seat_number');
    }
}
