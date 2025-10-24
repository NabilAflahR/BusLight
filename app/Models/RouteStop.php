<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteStop extends Model
{
    protected $table = 'route_stops';

    protected $fillable = [
        'route_id',
        'stop_id',
        'distance_from_start_km',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function stop()
    {
        return $this->belongsTo(Stop::class);
    }
}
