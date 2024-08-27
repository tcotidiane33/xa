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
        // 2024_08_11_000002_create_clients_and_gestionnaires_tables.php
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('responsable_paie_id')->nullable()->constrained('users');
            $table->foreignId('gestionnaire_principal_id')->nullable()->constrained('users');
            $table->date('date_debut_prestation')->nullable();
            $table->date('date_estimative_envoi_variables')->nullable();
            $table->date('date_rappel_mail')->nullable();
            $table->string('contact_paie')->nullable();
            $table->string('contact_comptabilite')->nullable();
            $table->timestamps();
        });

        Schema::create('gestionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('GID')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('responsable_id')->nullable()->constrained('users');
            $table->foreignId('superviseur_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('gestionnaires');
    }
};
