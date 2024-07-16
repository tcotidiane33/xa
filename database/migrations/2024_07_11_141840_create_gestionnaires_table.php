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
        Schema::create('gestionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('GID');
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->integer('nbr_bull');
            // $table->date('maj_fiche_para');
            // $table->date('reception_variable');
            // $table->date('preparation_bp');
            // $table->date('validation_bp_client');
            // $table->date('preparation_envoie_dsn');
            // $table->date('accuses_dsn');
            // $table->date('teledec_urssaf');
            $table->longText('notes')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Nous n'avons pas besoin d'ajouter des clés étrangères pour fonction, domaine et habilitation ici
            // car ces relations sont déjà définies dans la table 'users'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaires');
    }
};
