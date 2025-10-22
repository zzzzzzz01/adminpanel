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
        Schema::create('midterm_grades', function (Blueprint $table) {
            $table->id();

            // Talaba
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            // Topshiriq (submissons)
            $table->foreignId('assignment_submission_id')->nullable()->constrained('assignment_submissions')->nullOnDelete();

            $table->foreignId('group_subject_id')
            ->constrained()
            ->onDelete('cascade');

            // Bahosi
            $table->unsignedInteger('grade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midterm_grades');
    }
};
