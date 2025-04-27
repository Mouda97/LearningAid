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
        if (!Schema::hasTable('quizzes')) {
            Schema::create('quizzes', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->boolean('completed')->default(false);
                $table->text('description')->nullable();
                $table->enum('visibilite', ['prive', 'public'])->default('prive');
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
        Schema::dropIfExists('quizzes');
    }
};
