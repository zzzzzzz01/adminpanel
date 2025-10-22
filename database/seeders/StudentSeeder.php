<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tasodifiy nomlar va familiyalar
        $names = ['Ali', 'Vali', 'Doniyor', 'Murod', 'Zafar', 'Aziz', 'Jasur', 'Bobur', 'Dilshod', 'Olim'];
        $lastNames = ['Ismoilov', 'Jumayev', 'Tursunov', 'Abdullayev', 'Saidov', 'Karimov', 'Mamatqulov', 'Xodiev', 'Djalilov', 'Akramov'];
        $middleNames = ['Sardorovich', 'Dilmurodovich', 'Jasurovich', 'Olimovich', 'Zokirovich', 'Azimovich', 'Valiyevich', 'Murodovich', 'Anvarovich', 'Dostonovich'];

        for ($i = 1; $i <= 30; $i++) {
            $user = User::create([
                'name' => $names[array_rand($names)],
                'last_name' => $lastNames[array_rand($lastNames)],
                'middle_name' => $middleNames[array_rand($middleNames)],
                'birth_date' => Carbon::now()->subYears(rand(18, 30)), // 18-30 yosh o'rtasida tasodifiy sana
                'email' => 'user' . $i . '@example.com',
                'phone' => '+99890' . rand(1000000, 9999999), // Tasodifiy telefon raqami
                'photo' => null,
                'password' => bcrypt('secret'), // O'zgartiring agar kerak bo'lsa
                'email_verified_at' => null,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'group_id' => 1,
                'payment_id' => 1,
                'address' => null,
                'specialization' => null,
                'degree' => null,
                'experience' => null,
                'certificate' => null,
                'social_links' => null,
                'description' => null,
            ]);

            // Har bir foydalanuvchiga rolni qo'shish
            $user->roles()->attach([2]); // Rol ID sini o'zgartiring agar kerak bo'lsa
        }
    }
}
