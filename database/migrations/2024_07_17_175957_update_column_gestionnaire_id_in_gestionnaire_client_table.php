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
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            // Ajout de la colonne `gestionnaires_ids`
            $table->json('gestionnaires_ids')->nullable()->after('is_principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            // Suppression de la colonne `gestionnaires_ids`
            $table->dropColumn('gestionnaires_ids');
        });
    }
};
