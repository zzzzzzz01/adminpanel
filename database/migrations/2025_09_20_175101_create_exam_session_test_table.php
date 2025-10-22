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
        Schema::create('exam_session_test', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_session_id')->constrained('exam_sessions')->onDelete('cascade');

            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_session_test');
    }
};
