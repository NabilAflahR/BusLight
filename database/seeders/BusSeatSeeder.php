<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bus;
use App\Models\BusSeat;

class BusSeatSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BusSeat::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $buses = Bus::all();

        foreach ($buses as $bus) {
            for ($i = 1; $i <= $bus->capacity; $i++) {
                BusSeat::create([
                    'bus_id' => $bus->id,
                    'seat_number' => 'S' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'is_available' => true,
                ]);
            }
        }
    }
}
