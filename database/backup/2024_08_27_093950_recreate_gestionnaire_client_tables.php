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
        // Assurez-vous que la table 'gestionnaires' existe
        // if (!Schema::hasTable('gestionnaires')) {
        //     Schema::create('gestionnaires', function (Blueprint $table) {
        //         $table->id();
        //         $table->foreignId('user_id')->constrained();
        //         $table->string('GID')->unique();
        //         $table->timestamps();
        //     });
        // }

        // Schema::create('gestionnaire_client', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('client_id')->constrained();
        //     $table->foreignId('gestionnaire_id')->constrained('users'); // Notez que cela fait référence à 'users', pas à 'gestionnaires'
        //     $table->boolean('is_principal')->default(false);
        //     $table->json('gestionnaires_secondaires')->nullable();
        //     $table->foreignId('user_id')->constrained(); // Pour le responsable paie
        //     $table->text('notes')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaire_client');
    }
};
