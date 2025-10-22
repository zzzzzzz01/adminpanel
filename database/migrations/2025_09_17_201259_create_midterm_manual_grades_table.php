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
        Schema::create('midterm_manual_grades', function (Blueprint $table) {
            $table->id();
            // Guruh va fan
            $table->foreignId('group_subject_id')->constrained()->cascadeOnDelete();

            // interval o‘chsa baholar ham o‘chadi
            $table->foreignId('midterm_interval_id')->constrained()->cascadeOnDelete();

            // student o‘chsa baho ham o‘chadi
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();   
            
            $table->unsignedInteger('grade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midterm_manual_grades');
    }
};
