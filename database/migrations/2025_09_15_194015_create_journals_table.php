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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_subject_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Ballar uchun ustunlar
            $table->unsignedInteger('current_max')->default(30);   // Joriy
            $table->unsignedInteger('midterm_max')->default(30);   // Oraliq
            $table->unsignedInteger('final_max')->default(40);     // Yakuniy

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
