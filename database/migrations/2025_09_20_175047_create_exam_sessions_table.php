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
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            
            // Qaysi testga tegishli
            // $table->foreignId('test_id')->constrained()->onDelete('cascade');
    
            // Boshlanish va tugash vaqti
            $table->dateTime('start_time');
            $table->dateTime('end_time');
    
            // Xona (masalan: 201-xona, Zoom link va h.k.)
            $table->string('room')->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};
