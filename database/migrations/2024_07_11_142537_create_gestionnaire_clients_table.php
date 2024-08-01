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
        Schema::create('gestionnaire_client', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gestionnaire_id');
            $table->unsignedBigInteger('client_id');
            $table->boolean('is_principal')->default(false);
            $table->timestamps();

            $table->foreign('gestionnaire_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaire_client');
    }
};
