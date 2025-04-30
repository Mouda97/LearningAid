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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('nombre_questions')->default(0);
            $table->integer('temps_limite')->nullable(); // En minutes
            $table->enum('statut', ['brouillon', 'publié', 'archivé'])->default('brouillon'); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['nombre_questions','temps_limite','statut']);  //
        });
    }
};
