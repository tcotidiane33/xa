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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('fonction_id')->nullable()->after('password');
            $table->unsignedBigInteger('domaine_id')->nullable()->after('fonction_id');
            $table->unsignedBigInteger('habilitation_id')->nullable()->after('domaine_id');

            $table->foreign('fonction_id')->references('id')->on('fonctions')->onDelete('set null');
            $table->foreign('domaine_id')->references('id')->on('domaines')->onDelete('set null');
            $table->foreign('habilitation_id')->references('id')->on('habilitations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['fonction_id']);
            $table->dropForeign(['domaine_id']);
            $table->dropForeign(['habilitation_id']);

            $table->dropColumn('fonction_id');
            $table->dropColumn('domaine_id');
            $table->dropColumn('habilitation_id');
        });
    }
};
