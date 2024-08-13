<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('traitements_paie', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();

            // Assurez-vous que la table users utilise 'id' de type unsignedBigInteger
            $table->foreignId('gestionnaire_id')->constrained('users');

            // Le champ client_id doit référencer la table clients (par défaut Laravel infère 'clients')
            $table->foreignId('client_id')->constrained('clients');

            // Spécifiez explicitement la table si elle ne suit pas la convention de nommage standard
            $table->foreignId('periode_paie_id')->constrained('periodes_paie');

            $table->integer('nbr_bull');
            // $table->string('pj_nbr_bull')->nullable();
            $table->date('maj_fiche_para')->nullable();
            // $table->string('pj_maj_fiche_para')->nullable();
            $table->date('reception_variable')->nullable();
            // $table->string('pj_reception_variable')->nullable();
            $table->date('preparation_bp')->nullable();
            // $table->string('pj_preparation_bp')->nullable();
            $table->date('validation_bp_client')->nullable();
            // $table->string('pj_validation_bp_client')->nullable();
            $table->date('preparation_envoie_dsn')->nullable();
            // $table->string('pj_preparation_envoie_dsn')->nullable();
            // $table->string('link_preparation_envoie_dsn')->nullable();
            $table->date('accuses_dsn')->nullable();
            // $table->string('pj_accuses_dsn')->nullable();
            // $table->string('link_accuses_dsn')->nullable();
            $table->date('teledec_urssaf')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('est_verrouille')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traitements_paie');
    }

};
