<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('schedules', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('room')->nullable();  
        //     $table->time('start_time');
        //     $table->time('end_time');
        //     $table->timestamps();
        
        //     $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
        //     $table->foreignId('teacher_user_id')->constrained('users')->onDelete('cascade');
        //     $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
        //     $table->foreignId('weekday_id')->constrained('weekdays')->onDelete('cascade');
        //     $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
        // });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // $table->string('room')->nullable();  
            // $table->time('start_time');
            // $table->time('end_time');
            $table->date('date');
            $table->foreignId('auditorium_id')->constrained('auditoriums')->onDelete('cascade');
            $table->foreignId('lesson_pair_id')->constrained()->onDelete('cascade');
            $table->foreignId('week_id')->constrained('weeks')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            // $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            
            $table->foreignId('group_subject_id')->constrained('group_subjects')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
