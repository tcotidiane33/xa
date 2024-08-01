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
        // Ajout des colonnes dans la table 'gestionnaires'
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->unsignedBigInteger('responsable_id')->nullable()->after('is_principal');
            $table->unsignedBigInteger('superviseur_id')->nullable()->after('gestionnaire_id');
            $table->longText('notes')->nullable();
            // Clés étrangères pour les relations
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('superviseur_id')->references('id')->on('users')->onDelete('set null');
        });

        // Ajout de la colonne 'avatar' dans la table 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression des colonnes dans la table 'gestionnaires'
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropForeign(['superviseur_id']);
            $table->dropColumn(['responsable_id', 'superviseur_id', 'avatar']);
        });

        // Suppression de la colonne 'avatar' dans la table 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
