<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::create(['name' => 'Soliqlar va byudjet hisobi fakulteti', 'faculty_type' => 'Mahalliy']);
        Faculty::create(['name' => 'Raqamli iqtisodiyot va axborot texnologiyalari', 'faculty_type' => 'Mahalliy']);
        Faculty::create(['name' => 'Menejment fakulteti', 'faculty_type' => 'Mahalliy']);
    }
}
