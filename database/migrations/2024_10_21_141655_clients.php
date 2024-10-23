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
        Schema::table('clients', function (Blueprint $table) {
               // Informations société
            //    $table->string('name');
               $table->string('type_societe')->nullable();
               $table->string('ville')->nullable();
               $table->string('dirigeant_nom')->nullable();
               $table->string('dirigeant_telephone')->nullable();
               $table->string('dirigeant_email')->nullable();
   
               // Contact Paie
               $table->string('contact_paie_nom')->nullable();
               $table->string('contact_paie_prenom')->nullable();
               $table->string('contact_paie_telephone')->nullable();
               $table->string('contact_paie_email')->nullable();
   
               // Contact Comptabilité
               $table->string('contact_compta_nom')->nullable();
               $table->string('contact_compta_prenom')->nullable();
               $table->string('contact_compta_telephone')->nullable();
               $table->string('contact_compta_email')->nullable();
   
               // Informations Internes
            //    $table->foreignId('responsable_paie_id')->nullable()->constrained('users');
            //    $table->foreignId('gestionnaire_principal_id')->nullable()->constrained('users');
               $table->foreignId('binome_id')->nullable()->constrained('users');
               
               // Téléphones directs
               $table->string('responsable_telephone_ld')->nullable();
               $table->string('gestionnaire_telephone_ld')->nullable();
               $table->string('binome_telephone_ld')->nullable();
   
               // Autres informations
            //    $table->date('date_debut_prestation')->nullable();
            //    $table->date('date_estimative_envoi_variables')->nullable();
            //    $table->date('date_rappel_mail')->nullable();
            //    $table->integer('nb_bulletins')->default(0);
            //    $table->date('maj_fiche_para')->nullable();
            //    $table->foreignId('convention_collective_id')->nullable()->constrained('convention_collectives');
            //    $table->boolean('is_portfolio')->default(false);
            //    $table->foreignId('parent_client_id')->nullable()->constrained('clients');
            //    $table->string('status')->default('actif');
            //    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('type_societe')->nullable();
            $table->string('ville')->nullable();
            $table->string('dirigeant_nom')->nullable();
            $table->string('dirigeant_telephone')->nullable();
            $table->string('dirigeant_email')->nullable();

            // Contact Paie
            $table->string('contact_paie_nom')->nullable();
            $table->string('contact_paie_prenom')->nullable();
            $table->string('contact_paie_telephone')->nullable();
            $table->string('contact_paie_email')->nullable();

            // Contact Comptabilité
            $table->string('contact_compta_nom')->nullable();
            $table->string('contact_compta_prenom')->nullable();
            $table->string('contact_compta_telephone')->nullable();
            $table->string('contact_compta_email')->nullable();

            // Informations Internes
    
            $table->foreignId('binome_id')->nullable()->constrained('users');
            
            // Téléphones directs
            $table->string('responsable_telephone_ld')->nullable();
            $table->string('gestionnaire_telephone_ld')->nullable();
            $table->string('binome_telephone_ld')->nullable();
        });
    }
};
