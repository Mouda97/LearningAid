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
        Schema::table('cards', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('note_id')->after('user_id');

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
        }); //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['note_id']);
            $table->dropColumn(['user_id', 'note_id']);
        }); //
    }
};
