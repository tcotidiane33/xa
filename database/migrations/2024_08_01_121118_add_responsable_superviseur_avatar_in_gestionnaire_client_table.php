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
        Schema::table('gestionnaires', function (Blueprint $table) {
            $table->unsignedBigInteger('responsable_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('superviseur_id')->nullable()->after('responsable_id');
            $table->string('avatar')->nullable()->after('notes');

            // Clés étrangères pour les relations
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('superviseur_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestionnaires', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropForeign(['superviseur_id']);
            $table->dropColumn(['responsable_id', 'superviseur_id', 'avatar']);

        });
    }
};
