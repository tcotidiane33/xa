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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('responsable_paie_id')->nullable();
            $table->unsignedBigInteger('gestionnaire_principal_id')->nullable();
            $table->timestamps();

            $table->foreign('responsable_paie_id')->references('id')->on('users');
            $table->foreign('gestionnaire_principal_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
