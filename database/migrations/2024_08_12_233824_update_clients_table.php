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
        Schema::table('clients', function (Blueprint $table) {
            // $table->unsignedBigInteger('responsable_paie_id')->nullable();
            // $table->unsignedBigInteger('gestionnaire_principal_id')->nullable();
            // $table->date('date_debut_prestation')->nullable();
            // $table->string('contact_paie')->nullable();
            // $table->string('contact_comptabilite')->nullable();
            $table->integer('nb_bulletins')->default(0);
            $table->date('maj_fiche_para')->nullable();
            $table->unsignedBigInteger('convention_collective_id')->nullable();
            // $table->string('status')->default('actif');

            // $table->foreign('responsable_paie_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('gestionnaire_principal_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('convention_collective_id')->references('id')->on('convention_collective')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // $table->dropForeign(['responsable_paie_id']);
            // $table->dropForeign(['gestionnaire_principal_id']);
            $table->dropForeign(['convention_collective_id']);

            $table->dropColumn([
                // 'responsable_paie_id',
                // 'gestionnaire_principal_id',
                // 'date_debut_prestation',
                // 'contact_paie',
                // 'contact_comptabilite',
                'nb_bulletins',
                'maj_fiche_para',
                'convention_collective_id',
                // 'status'
            ]);
        });
    }
};
