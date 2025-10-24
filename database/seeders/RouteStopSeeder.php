<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RouteStop;
use Illuminate\Support\Facades\DB;
class RouteStopSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        RouteStop::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $routeStops = [
            // Koridor 1
            ['route_id' => 6, 'stop_id' => 1, 'distance_from_start_km' => 0],
            ['route_id' => 6, 'stop_id' => 2, 'distance_from_start_km' => 5],
            ['route_id' => 6, 'stop_id' => 3, 'distance_from_start_km' => 10],
            ['route_id' => 6, 'stop_id' => 4, 'distance_from_start_km' => 15],
            ['route_id' => 6, 'stop_id' => 5, 'distance_from_start_km' => 20],

            // Koridor 2
            ['route_id' => 7, 'stop_id' => 6, 'distance_from_start_km' => 0],
            ['route_id' => 7, 'stop_id' => 7, 'distance_from_start_km' => 6],
            ['route_id' => 7, 'stop_id' => 8, 'distance_from_start_km' => 12],
            ['route_id' => 7, 'stop_id' => 9, 'distance_from_start_km' => 18],
        ];

        RouteStop::insert($routeStops);
    }
}

