<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->dropColumn('gestionnaires_secondaires');
            $table->dropColumn('is_principal');
        });

        Schema::create('gestionnaire_client_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('gestionnaire_id');
            $table->boolean('is_principal')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('gestionnaire_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['client_id', 'gestionnaire_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaire_client_pivot');

        Schema::table('gestionnaire_client', function (Blueprint $table) {
            $table->json('gestionnaires_secondaires')->nullable();
            $table->boolean('is_principal')->default(false);
        });
        
    }
};
