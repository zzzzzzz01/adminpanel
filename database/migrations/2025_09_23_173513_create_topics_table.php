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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_subject_id')->constrained('group_subjects')->onDelete('cascade');
            $table->string('title'); // mavzu nomi
            $table->string('file_path')->nullable(); // yuklangan fayl yo‘li
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // kim yuklagan (admin yoki teacher)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
