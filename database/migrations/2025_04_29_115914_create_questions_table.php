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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Liaison à un quiz
            $table->text('question_text');
            $table->text('correct_answer');
            $table->json('incorrect_answers'); // Stocker les réponses incorrectes comme un tableau JSON
            $table->enum('type', ['choix_multiple', 'vrai_faux', 'reponse_courte'])->default('choix_multiple');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
