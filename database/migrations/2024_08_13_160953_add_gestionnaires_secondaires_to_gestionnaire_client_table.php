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
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->json('gestionnaires_secondaires')->nullable()->after('is_principal');
        });
    }

    public function down()
    {
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->dropColumn('gestionnaires_secondaires');
        });
    }
};
