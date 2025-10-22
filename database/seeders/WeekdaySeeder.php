<?php

namespace Database\Seeders;

use App\Models\Weekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeekdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weekday::create(['name_uz' => 'Dushanba', 'name_ru' => 'Понедельник', 'name_en' => 'Monday']);
        Weekday::create(['name_uz' => 'Seshanba', 'name_ru' => 'Вторник', 'name_en' => 'Tuesday']);
        Weekday::create(['name_uz' => 'Chorshanba', 'name_ru' => 'Среда', 'name_en' => 'Wednesday']);
        Weekday::create(['name_uz' => 'Payshanba', 'name_ru' => 'Четверг', 'name_en' => 'Thursday']);
        Weekday::create(['name_uz' => 'Juma', 'name_ru' => 'Пятница', 'name_en' => 'Friday']);
        Weekday::create(['name_uz' => 'Shanba', 'name_ru' => 'Суббота', 'name_en' => 'Saturday']);
    }
}
