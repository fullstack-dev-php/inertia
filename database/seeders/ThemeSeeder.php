<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        $today = Carbon::today()->format('Y-m-d');

        DB::table('themes')->insert([
            // 1: 10:00 - 10:30 ✅ Thỏa
            [
                'start_time' => "{$today} 10:00:00",
                'end_time'   => "{$today} 10:30:00",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2: NULL - 10:30 ✅ Thỏa
            [
                'start_time' => null,
                'end_time'   => "{$today} 10:30:00",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3: 10:00 - NULL ✅ Thỏa
            [
                'start_time' => "{$today} 10:00:00",
                'end_time'   => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4: NULL - NULL ✅ Thỏa
            [
                'start_time' => null,
                'end_time'   => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5: 10:15 - 10:30 ❌ Sai
            [
                'start_time' => "{$today} 10:15:00",
                'end_time'   => "{$today} 10:30:00",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6: 10:00 - 10:15 ❌ Sai
            [
                'start_time' => "{$today} 10:00:00",
                'end_time'   => "{$today} 10:15:00",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
