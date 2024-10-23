<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('saisie_variables')->default(false);
            $table->boolean('client_forme_saisie')->default(false);
            $table->date('date_formation_saisie')->nullable();
            $table->date('date_fin_prestation')->nullable();
            $table->date('date_signature_contrat')->nullable();
            $table->string('taux_at')->nullable();
            $table->boolean('adhesion_mydrh')->default(false);
            $table->date('date_adhesion_mydrh')->nullable();

            
             // Nouveaux champs pour cabinet et portefeuille cabinet
             $table->boolean('is_cabinet')->default(false);
             $table->unsignedBigInteger('portfolio_cabinet_id')->nullable();
 
             $table->foreign('portfolio_cabinet_id')->references('id')->on('clients')->onDelete('set null'); 
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'saisie_variables',
                'client_forme_saisie',
                'date_formation_saisie',
                'date_fin_prestation',
                'date_signature_contrat',
                'taux_at',
                'adhesion_mydrh',
                'date_adhesion_mydrh',
                'is_cabinet',
                'portfolio_cabinet_id',
            ]);
        });
    }
};