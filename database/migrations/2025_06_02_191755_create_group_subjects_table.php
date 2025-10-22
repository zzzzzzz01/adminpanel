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
        Schema::create('group_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('max_current_score')->default(0);   // Joriy ball
            $table->unsignedInteger('max_midterm_score')->default(0);   // Oraliq ball
            $table->unsignedInteger('max_final_score')->default(0);     // Yakuniy ball
            $table->unsignedInteger('total_score')->default(100);   // Umumiy ball
            $table->integer('audit_hours')->default(0);
            $table->timestamps();
        
            $table->unique(
                ['group_id','subject_id','semester_id'],
                'gs_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_subjects');
    }
};
