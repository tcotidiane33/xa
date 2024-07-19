<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->date('date_debut_prestation')->nullable();
            // $table->string('convention_collective')->nullable();
            $table->string('contact_paie')->nullable();
            $table->string('contact_comptabilite')->nullable();
            $table->date('maj_fiche_para')->nullable();
            $table->string('code_acces')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('date_debut_prestation');
            // $table->dropColumn('convention_collective');
            $table->dropColumn('contact_paie');
            $table->dropColumn('contact_comptabilite');
            $table->dropColumn('maj_fiche_para');
            $table->dropColumn('code_acces');
        });
    }
};
