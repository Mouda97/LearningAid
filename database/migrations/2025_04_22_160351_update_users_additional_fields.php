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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('email');
            $table->enum('role', ['etudiant', 'administrateur'])->default('etudiant')->after('profile_photo');
            $table->date('registration_date')->default(now())->after('role');
            $table->boolean('is_active')->default(true)->after('registration_date');
        });//

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'role',
                'registration_date',
                'is_active',
            ]);
        });//
        
    }
};
