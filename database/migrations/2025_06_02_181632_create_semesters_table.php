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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Masalan: "1-semester", "2-semester"
            $table->foreignId('group_id')->constrained()->onDelete('cascade'); // Guruh bilan bog‘lanadi
            $table->unsignedInteger('semester_number'); // qo‘shildi
            $table->date('start_date'); // boshlanish sanasi
            $table->date('end_date');   // tugash sanasi
            $table->string('academic_year');

            $table->unique(['group_id', 'semester_number']); // Bir guruhda bir xil semestr bo‘lmasligi uchun
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
