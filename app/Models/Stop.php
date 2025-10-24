<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    protected $table = 'stops';

    protected $fillable = [
        'name',
        'location',
        'route_id',
        'order_index',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
