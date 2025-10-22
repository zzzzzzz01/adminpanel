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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('midterm_interval_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('max_score')->default(100);
            $table->integer('attempts')->default(1);
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->string('file')->nullable(); // fayl saqlanadi
            $table->boolean('status')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
