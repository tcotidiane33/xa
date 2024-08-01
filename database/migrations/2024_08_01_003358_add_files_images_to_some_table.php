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
        Schema::table('traitements_paie', function (Blueprint $table) {
            // Adding new fields for document tracking
            $table->string('pj_nbr_bull')->nullable()->after('nbr_bull');
            $table->string('pj_maj_fiche_para')->nullable()->after('maj_fiche_para');
            $table->string('pj_reception_variable')->nullable()->after('reception_variable');
            $table->string('pj_preparation_bp')->nullable()->after('preparation_bp');
            $table->string('pj_validation_bp_client')->nullable()->after('validation_bp_client');
            $table->string('pj_preparation_envoie_dsn')->nullable()->after('preparation_envoie_dsn');
            $table->string('link_preparation_envoie_dsn')->nullable()->after('pj_preparation_envoie_dsn');
            $table->string('pj_accuses_dsn')->nullable()->after('accuses_dsn');
            $table->string('link_accuses_dsn')->nullable()->after('pj_accuses_dsn');
            $table->boolean('listBoxIsEmpty')->default(false)->after('link_accuses_dsn');
        });

        Schema::table('clients', function (Blueprint $table) {
            // Adding date fields to clients table
            $table->date('date_estimate_send_var')->nullable()->after('responsable_paie_id');
            $table->date('date_feedback_mail')->nullable()->after('gestionnaire_principal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traitements_paie', function (Blueprint $table) {
            // Dropping the newly added columns
            $table->dropColumn('pj_nbr_bull');
            $table->dropColumn('pj_maj_fiche_para');
            $table->dropColumn('pj_reception_variable');
            $table->dropColumn('pj_preparation_bp');
            $table->dropColumn('pj_validation_bp_client');
            $table->dropColumn('pj_preparation_envoie_dsn');
            $table->dropColumn('link_preparation_envoie_dsn');
            $table->dropColumn('pj_accuses_dsn');
            $table->dropColumn('link_accuses_dsn');
            $table->dropColumn('listBoxIsEmpty');
        });

        Schema::table('clients', function (Blueprint $table) {
            // Dropping the newly added date columns
            $table->dropColumn('date_estimate_send_var');
            $table->dropColumn('date_feedback_mail');
        });
    }
};
