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
        Schema::create('traitements_paie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gestionnaire_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('periode_paie_id');
            $table->integer('nbr_bull');
            $table->date('maj_fiche_para')->nullable();
            $table->date('reception_variable')->nullable();
            $table->date('preparation_bp')->nullable();
            $table->date('validation_bp_client')->nullable();
            $table->date('preparation_envoie_dsn')->nullable();
            $table->date('accuses_dsn')->nullable();
            $table->date('teledec_urssaf')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('gestionnaire_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('periode_paie_id')->references('id')->on('periodes_paie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traitement_paie');
    }
};
