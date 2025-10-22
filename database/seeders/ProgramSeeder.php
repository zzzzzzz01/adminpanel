<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Program::create(['name' => 'Raqamli iqtisodiyot (tarmoqlar va sohalar bo\'yicha)', 'faculty_id' => '2', 'code' => '60310501', 'description' => 'Raqamli iqtisodiyot
        yo\'nalishi raqamli biznes, ma\'lumotlar tahlili, raqamli moliya, o\'zgaruvchan ishchi kuchi, innovatsiyalar va raqamli infratuzilmani o\'z ichiga oladi. Bu jihatlar
        raqamli texnologiyalar yordamida iqtisodiy faoliyatni rivojlantirishni ta\'minlaydi.']);
        
        Program::create(['name' => 'Sug\'urta ishi', 'faculty_id' => '1', 'code' => '60410600', 'description' => 'Sug\'urta ishi yo\'nalishlari quyidagilardan iborat: 
        hayot sug\'urtasi, sog\'liq sug\'urtasi, mulk sug\'urtasi, mas\'uliyat sug\'urtasi, transport sug\'urtasi va iqtisodiy sug\'urta. Har biri turli xavflarni himoya
        qilishga qaratilgan.']);


        Program::create(['name' => 'Marketing', 'faculty_id' => '3', 'code' => '60411200', 'description' => 'Marketing yo\'nalishi raqamli texnologiyalar yordamida iste\'molchilarning
        ehtiyojlarini aniqlash va mahsulotlarni targ\'ib qilishni ta\'minlaydi. Raqamli marketing strategiyalari brendni yaratish va mijozlar bilan aloqani mustahkamlashga yordam beradi.
        ']);
    }
}
