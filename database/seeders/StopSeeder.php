<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stop;
use Illuminate\Support\Facades\DB;

class StopSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Stop::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $stops = [
            // Halte untuk Koridor 1 (Blok M - Kota)
            ['name' => 'Blok M', 'location' => 'Jakarta Selatan', 'route_id' => 6, 'order_index' => 1],
            ['name' => 'Senayan', 'location' => 'Jakarta Pusat', 'route_id' => 6, 'order_index' => 2],
            ['name' => 'Dukuh Atas', 'location' => 'Jakarta Pusat', 'route_id' => 6, 'order_index' => 3],
            ['name' => 'Harmoni', 'location' => 'Jakarta Pusat', 'route_id' => 6, 'order_index' => 4],
            ['name' => 'Kota', 'location' => 'Jakarta Barat', 'route_id' => 6, 'order_index' => 5],

            // Halte untuk Koridor 2 (Harmoni - Pulo Gadung)
            ['name' => 'Harmoni', 'location' => 'Jakarta Pusat', 'route_id' => 7, 'order_index' => 1],
            ['name' => 'Cempaka Putih', 'location' => 'Jakarta Pusat', 'route_id' => 7, 'order_index' => 2],
            ['name' => 'Rawasari', 'location' => 'Jakarta Timur', 'route_id' => 7, 'order_index' => 3],
            ['name' => 'Pulo Gadung', 'location' => 'Jakarta Timur', 'route_id' => 7, 'order_index' => 4],
        ];

        Stop::insert($stops);
    }
}
