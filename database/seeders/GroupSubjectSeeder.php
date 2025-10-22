<?php

namespace Database\Seeders;

use App\Models\GroupSubject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupSubject::create(['group_id' => '1', 'subject_id' => '1', 'teacher_id' => '3', 'semester_id' => '1', 'max_current_score' => '20', 
        'max_midterm_score' => '30', 'max_final_score' => '50', 'total_score' => '100', 'audit_hours' => '60']);

        GroupSubject::create(['group_id' => '1', 'subject_id' => '2', 'teacher_id' => '3', 'semester_id' => '1', 'max_current_score' => '20',  
        'max_midterm_score' => '30', 'max_final_score' => '50', 'total_score' => '100', 'audit_hours' => '60']);

        GroupSubject::create(['group_id' => '1', 'subject_id' => '3', 'teacher_id' => '3', 'semester_id' => '1', 'max_current_score' => '20',
        'max_midterm_score' => '30', 'max_final_score' => '50', 'total_score' => '100', 'audit_hours' => '60']);

        GroupSubject::create(['group_id' => '1', 'subject_id' => '4', 'teacher_id' => '3', 'semester_id' => '1', 'max_current_score' => '20', 
        'max_midterm_score' => '30', 'max_final_score' => '50', 'total_score' => '100', 'audit_hours' => '60']);
    }
}
