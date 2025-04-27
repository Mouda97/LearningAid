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
        if (!Schema::hasTable('flashcards')) {
                Schema::create('flashcards', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->string('answer');
                $table->boolean('revised')->default(false);
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        } 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
