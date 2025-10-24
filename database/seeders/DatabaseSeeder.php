<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\BusSeat;
use App\Models\Stop;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BusSeeder::class,
            BusSeatSeeder::class,
            RouteSeeder::class,
            StopSeeder::class,
            RouteStopSeeder::class,
            ScheduleSeeder::class,
        ]);
    }

}
