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
        // Schema::create('groups', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('course');
        //     $table->string('name')->nullable();
        //     $table->text('full_group_name');
        //     $table->timestamps();
        // });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
        
            $table->string('group_name')->nullable();
            $table->text('full_group_name');
            // $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->enum('education_type', ['Bakalavr', 'Magistratura', 'Doktorantura'])->default('Bakalavr');
        
            // O‘quv yillar
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete(); // masalan: 2025-2026
            $table->year('start_year');      // 2025
            $table->year('end_year');        // 2029 (hisoblab beriladi)

            $table->foreignId('program_id')->constrained()->onDelete('cascade');
        
            $table->unsignedTinyInteger('study_duration')->default(4); // yil
            $table->unsignedTinyInteger('total_semesters')->default(8);
            $table->unsignedTinyInteger('current_semester')->default(1);
            $table->boolean('is_graduated')->default(false);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
