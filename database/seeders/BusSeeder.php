<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bus;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Bus::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $buses = [
            ['no_license' => 'B1234XYZ', 'name' => 'TransCity Express', 'capacity' => 40, 'type' => 'Executive'],
            ['no_license' => 'B5678ABC', 'name' => 'SkyBus Comfort', 'capacity' => 35, 'type' => 'VIP'],
            ['no_license' => 'B9988RTY', 'name' => 'MetroLine Plus', 'capacity' => 45, 'type' => 'Economy'],
            ['no_license' => 'B8899KLM', 'name' => 'LuxRide Premium', 'capacity' => 32, 'type' => 'Luxury'],
            ['no_license' => 'B2233PQR', 'name' => 'GoBus Travel', 'capacity' => 50, 'type' => 'Regular'],

            ['no_license' => 'TJ1001', 'name' => 'TransJakarta Koridor 1', 'capacity' => 60, 'type' => 'Busway'],
            ['no_license' => 'TJ1002', 'name' => 'TransJakarta Koridor 2', 'capacity' => 55, 'type' => 'Busway'],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }
    }
}
