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
        Schema::table('periodes_paie', function (Blueprint $table) {
            $table->date('reception_variables')->nullable()->after('client_id');
            $table->date('preparation_bp')->nullable()->after('reception_variables');
            $table->date('validation_bp_client')->nullable()->after('preparation_bp');
            $table->date('preparation_envoie_dsn')->nullable()->after('validation_bp_client');
            $table->date('accuses_dsn')->nullable()->after('preparation_envoie_dsn');
            $table->text('notes')->nullable()->after('accuses_dsn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('periodes_paie', function (Blueprint $table) {
            $table->dropColumn(['reception_variables', 'preparation_bp', 'validation_bp_client', 'preparation_envoie_dsn', 'accuses_dsn', 'notes']);
        });
    }
};
