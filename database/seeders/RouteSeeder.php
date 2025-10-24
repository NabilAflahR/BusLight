<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Route::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $routes = [
            ['origin' => 'Jakarta', 'destination' => 'Bandung', 'distance_km' => 150, 'duration' => '03:00:00'],
            ['origin' => 'Bandung', 'destination' => 'Yogyakarta', 'distance_km' => 390, 'duration' => '08:30:00'],
            ['origin' => 'Jakarta', 'destination' => 'Surabaya', 'distance_km' => 780, 'duration' => '13:00:00'],
            ['origin' => 'Semarang', 'destination' => 'Malang', 'distance_km' => 350, 'duration' => '07:00:00'],
            ['origin' => 'Yogyakarta', 'destination' => 'Bali', 'distance_km' => 900, 'duration' => '16:00:00'],

            ['origin' => 'Blok M', 'destination' => 'Kota', 'distance_km' => 20, 'duration' => '00:45:00'],
            ['origin' => 'Harmoni', 'destination' => 'Pulo Gadung', 'distance_km' => 18, 'duration' => '00:40:00'],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
