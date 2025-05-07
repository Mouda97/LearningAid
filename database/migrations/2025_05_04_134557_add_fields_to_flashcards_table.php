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
            // Ajout des nouveaux champs
            $table->text('front')->nullable()->after('description');
            $table->text('back')->nullable()->after('front');
            $table->string('status')->default('new')->after('back'); // new, learning, mastered
            $table->enum('visibilite', ['privee', 'publique'])->default('privee')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flashcards', function (Blueprint $table) {
            // Suppression des champs en cas de rollback
            $table->dropColumn(['front', 'back', 'status', 'visibilite']);
        });
    }
};