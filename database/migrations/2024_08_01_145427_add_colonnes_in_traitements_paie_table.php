<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('traitements_paie', function (Blueprint $table) {
            // Ajout de nouvelles colonnes
            $table->unsignedBigInteger('superviseur_id')->nullable()->after('gestionnaire_id');
            $table->unsignedBigInteger('responsable_id')->nullable()->after('superviseur_id');
            $table->json('gestionnaires_ids')->nullable()->after('responsable_id');

            // Modification de la colonne gestionnaire_id pour la rendre nullable
            $table->unsignedBigInteger('gestionnaire_id')->nullable()->change();

            // Ajout des clés étrangères
            $table->foreign('superviseur_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');

            // Assurez-vous que la clé étrangère pour gestionnaire_id existe
            // Si elle n'existe pas déjà, décommentez la ligne suivante
            // $table->foreign('gestionnaire_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('traitements_paie', function (Blueprint $table) {
            // Supprimer les clés étrangères
            $table->dropForeign(['superviseur_id']);
            $table->dropForeign(['responsable_id']);

            // Supprimer les colonnes ajoutées
            $table->dropColumn('superviseur_id');
            $table->dropColumn('responsable_id');
            $table->dropColumn('gestionnaires_ids');

            // Remettre gestionnaire_id comme non nullable si nécessaire
            $table->unsignedBigInteger('gestionnaire_id')->nullable(false)->change();
        });
    }
};
