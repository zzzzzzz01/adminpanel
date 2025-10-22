<?php

namespace Database\Seeders;

use App\Models\LessonPair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LessonPair::create(['pair_number' => '1', 'start_time' => '08:30:00', 'end_time' => '09:50:00']);
        LessonPair::create(['pair_number' => '2', 'start_time' => '10:00:00', 'end_time' => '11:20:00']);
        LessonPair::create(['pair_number' => '3', 'start_time' => '11:30:00', 'end_time' => '12:50:00']);
        LessonPair::create(['pair_number' => '4', 'start_time' => '11:30:00', 'end_time' => '14:50:00']);
        LessonPair::create(['pair_number' => '5', 'start_time' => '15:00:00', 'end_time' => '16:20:00']);
        LessonPair::create(['pair_number' => '5', 'start_time' => '15:00:00', 'end_time' => '16:20:00']);
        LessonPair::create(['pair_number' => '6', 'start_time' => '16:30:00', 'end_time' => '17:50:00']);
        LessonPair::create(['pair_number' => '7', 'start_time' => '18:00:00', 'end_time' => '19:20:00']);
        LessonPair::create(['pair_number' => '8', 'start_time' => '19:30:00', 'end_time' => '20:50:00']);
    }
}
