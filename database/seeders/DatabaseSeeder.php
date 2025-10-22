<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            PaymentSeeder::class,
            SubjectSeeder::class,
            WeekdaySeeder::class,
            SessionSeeder::class,
            FacultySeeder::class,
            ProgramSeeder::class,
            AuditoriumSeeder::class,
            AcademicYearSeeder::class,
            LessonPairSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
            GroupSubjectSeeder::class,
            PostSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
