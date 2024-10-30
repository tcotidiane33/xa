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
        Schema::table('convention_collective', function (Blueprint $table) {
            $table->string('idcc', 4)->default('0000')->change();
        });

        // Mettre à jour les enregistrements existants
        DB::table('convention_collective')->whereNull('idcc')->orWhere('idcc', '')->update(['idcc' => DB::raw('LPAD(id, 4, "0")')]);

        Schema::table('convention_collective', function (Blueprint $table) {
            $table->string('idcc', 4)->unique()->change();
            $table->string('name')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convention_collective', function (Blueprint $table) {
            $table->string('idcc', 4)->unique();
            $table->string('name')->unique();

        });
    }
};
