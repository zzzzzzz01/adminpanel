<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create(['name_uz' => 'To\'lov shartnomasi', 'name_ru' => 'Платежное соглашение', 'name_en' => 'Payment Agreement']);
        Payment::create(['name_uz' => 'Davlat granti', 'name_ru' => 'Государственная грант', 'name_en' => 'State Grant']);
    }
}
