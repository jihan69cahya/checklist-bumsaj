<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat periode dari jam 7 pagi hingga jam 18 sore, setiap periode 2 jam
        $startHour = 7;
        $endHour = 18;
        $periodCounter = 1;

        // Loop untuk membuat periode dengan waktu mulai dan selesai setiap 2 jam
        for ($start = $startHour; $start < $endHour; $start += 2)
        {
            $startTime = sprintf('%02d:00:00', $start);
            $endTime = sprintf('%02d:00:00', $start + 2);

            Period::create([
                'period_start_time' => $startTime,
                'period_end_time' => $endTime,
                'period_label' => 'Periode ' . $periodCounter++
            ]);
        }
    }
}
