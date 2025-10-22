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
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');

            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->integer('week_number'); // 77, 78, 79 ...

            $table->date('start_date');     // 2025-02-03
            $table->date('end_date'); 
            $table->string('academic_year')->nullable(); // masalan: 2025-2026
            $table->enum('week_type', ['Nazariy talim', 'Tatil']);    // 2025-02-08
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weeks');
    }
};
