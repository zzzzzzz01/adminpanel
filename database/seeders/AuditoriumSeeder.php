<?php

namespace Database\Seeders;

use App\Models\Auditorium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auditorium::create(['name' => '101/2', 'capacity' => '30', 'building' => 'Bino-5']);
        Auditorium::create(['name' => '4/7', 'capacity' => '200', 'building' => 'Bino-C']);
        Auditorium::create(['name' => '103/1', 'capacity' => '50', 'building' => 'Bino-4']);
        Auditorium::create(['name' => '104/7', 'capacity' => '75', 'building' => 'Bino-1']);
        Auditorium::create(['name' => '4/2', 'capacity' => '150', 'building' => 'Bino-A']);
        Auditorium::create(['name' => '110/4', 'capacity' => '100', 'building' => 'Bino-2']);
    }
}
