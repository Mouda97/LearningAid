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
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['question', 'answer', 'revised']);
        }); // Ajout de l'accolade fermante et du point-virgule ici
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->boolean('revised')->default(false);
        });//
    }
};
