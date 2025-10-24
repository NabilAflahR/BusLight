<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schedule::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        $schedules = [
            ['bus_id' => 1, 'route_id' => 1, 'departure_time' => $now->copy()->addDays(1)->setTime(8, 0), 'price' => 150000, 'available_seats' => 40],
            ['bus_id' => 2, 'route_id' => 2, 'departure_time' => $now->copy()->addDays(2)->setTime(9, 30), 'price' => 300000, 'available_seats' => 35],
            ['bus_id' => 3, 'route_id' => 3, 'departure_time' => $now->copy()->addDays(3)->setTime(7, 0), 'price' => 450000, 'available_seats' => 45],
            ['bus_id' => 4, 'route_id' => 4, 'departure_time' => $now->copy()->addDays(4)->setTime(6, 30), 'price' => 350000, 'available_seats' => 32],
            ['bus_id' => 5, 'route_id' => 5, 'departure_time' => $now->copy()->addDays(5)->setTime(5, 0), 'price' => 550000, 'available_seats' => 50],

            // 🚌 Jadwal Busway
            ['bus_id' => 6, 'route_id' => 6, 'departure_time' => $now->copy()->setTime(6, 0), 'price' => 3500, 'available_seats' => 60],
            ['bus_id' => 6, 'route_id' => 6, 'departure_time' => $now->copy()->setTime(7, 0), 'price' => 3500, 'available_seats' => 60],
            ['bus_id' => 7, 'route_id' => 7, 'departure_time' => $now->copy()->setTime(6, 30), 'price' => 3500, 'available_seats' => 55],
            ['bus_id' => 7, 'route_id' => 7, 'departure_time' => $now->copy()->setTime(8, 0), 'price' => 3500, 'available_seats' => 55],
        ];


        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
