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
        Schema::create('midterm_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_subject_id')->constrained('group_subjects')->onDelete('cascade');
            $table->enum('type', ['manual', 'assignment']);
            $table->boolean('status')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midterm_intervals');
    }
};
