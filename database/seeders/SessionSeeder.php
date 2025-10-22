<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Session::create(['name_uz'=>'Ma\'ruza', 'name_ru'=>'Лекция', 'name_en'=>'lecture' ]);
        Session::create(['name_uz'=>'Seminar', 'name_ru'=>'Семинар', 'name_en'=>'Seminar' ]);
        Session::create(['name_uz'=>'Laboratoriya', 'name_ru'=>'Лабораторная работа', 'name_en'=>'Laboratory work' ]);
        Session::create(['name_uz'=>'Amaliy mashg\'ulot', 'name_ru'=>'Практическое занятие', 'name_en'=>'Practical session' ]);
    }
}
