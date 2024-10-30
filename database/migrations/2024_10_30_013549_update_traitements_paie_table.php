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
            // if (Schema::hasColumn('traitements_paie', 'reference')) {
            //     $table->string('reference')->unique()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'gestionnaire_id')) {
            //     $table->foreignId('gestionnaire_id')->nullable()->constrained('users')->onDelete('set null')->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'client_id')) {
            //     $table->foreignId('client_id')->constrained('clients')->onDelete('cascade')->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'periode_paie_id')) {
            //     $table->foreignId('periode_paie_id')->nullable()->constrained('periodes_paie')->onDelete('set null')->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'teledec_urssaf')) {
            //     $table->date('teledec_urssaf')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'est_verrouille')) {
            //     $table->boolean('est_verrouille')->default(false)->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'nb_bulletins_file')) {
            //     $table->string('nb_bulletins_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'maj_fiche_para_file')) {
            //     $table->string('maj_fiche_para_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'reception_variables_file')) {
            //     $table->string('reception_variables_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'preparation_bp_file')) {
            //     $table->string('preparation_bp_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'validation_bp_client_file')) {
            //     $table->string('validation_bp_client_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'preparation_envoi_dsn_file')) {
            //     $table->string('preparation_envoi_dsn_file')->nullable()->change();
            // }
            // if (Schema::hasColumn('traitements_paie', 'accuses_dsn_file')) {
            //     $table->string('accuses_dsn_file')->nullable()->change();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traitements_paie', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropColumn([
                'gestionnaire_id',
                'client_id',
                'periode_paie_id',
                'teledec_urssaf',
                'est_verrouille',
                'nb_bulletins_file',
                'maj_fiche_para_file',
                'reception_variables_file',
                'preparation_bp_file',
                'validation_bp_client_file',
                'preparation_envoi_dsn_file',
                'accuses_dsn_file',
            ]);
        });
    }
};
