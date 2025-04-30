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
            $table->string('title')->after('id');
            $table->text('description')->nullable()->after('title');
            $table->unsignedBigInteger('note_id')->after('user_id');
    
                // Clé étrangère vers la table notes
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            
        });  //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     //
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropForeign(['note_id']);
            $table->dropColumn(['title', 'description', 'note_id']);
        });
    }
};
