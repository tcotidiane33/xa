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
            $table->dropColumn([
                'reception_variable', 'preparation_bp', 'validation_bp_client',
                'preparation_envoie_dsn', 'accuses_dsn', 'notes'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traitements_paie', function (Blueprint $table) {
            $table->date('reception_variable')->nullable();
            $table->date('preparation_bp')->nullable();
            $table->date('validation_bp_client')->nullable();
            $table->date('preparation_envoie_dsn')->nullable();
            $table->date('accuses_dsn')->nullable();
            $table->text('notes')->nullable();
        });
    }
};
