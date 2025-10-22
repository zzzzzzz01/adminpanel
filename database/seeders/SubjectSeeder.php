<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create(['name_uz'=> 'Matematika', 'name_ru'=> 'Математика', 'name_en'=>'Mathematics']);
        Subject::create(['name_uz' => 'Fizika', 'name_ru' => 'Физика', 'name_en' => 'Physics']);
        Subject::create(['name_uz' => 'Ingliz tili', 'name_ru' => 'Английский язык', 'name_en' => 'English']);
        Subject::create(['name_uz' => 'Dasturlash', 'name_ru' => 'Программирование', 'name_en' => 'Programming']);
        Subject::create(['name_uz' => 'Kirish matematikasi', 'name_ru' => 'Введение в математику', 'name_en' => 'Introduction to Mathematics']);
        Subject::create(['name_uz' => 'Tashkiliy psixologiya', 'name_ru' => 'Организационная психология', 'name_en' => 'Organizational Psychology']);
        Subject::create(['name_uz' => 'Kirish iqtisodiyoti', 'name_ru' => 'Введение в экономику', 'name_en' => 'Introduction to Economics']);
        Subject::create(['name_uz' => 'Kirish statistikasini', 'name_ru' => 'Введение в статистику', 'name_en' => 'Introduction to Statistics']);
        Subject::create(['name_uz' => 'Tarbiyaviy pedagogika', 'name_ru' => 'Воспитательная педагогика', 'name_en' => 'Educational Pedagogy']);
        Subject::create(['name_uz' => 'Falsafa', 'name_ru' => 'Философия', 'name_en' => 'Philosophy']);
        Subject::create(['name_uz' => 'Biologiya', 'name_ru' => 'Биология', 'name_en' => 'Biology']);
        Subject::create(['name_uz' => 'Tarix', 'name_ru' => 'История', 'name_en' => 'History']);
    }
}
