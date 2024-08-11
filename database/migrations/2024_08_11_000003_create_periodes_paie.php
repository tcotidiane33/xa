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
        // 2024_08_11_000003_create_traitements_paie_table.php
        Schema::create('periodes_paie', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('debut');
            $table->date('fin');
            $table->boolean('validee')->default(false);
            $table->foreignId('client_id')->constrained();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes_paie');
    }

};
