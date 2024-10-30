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
        // 2024_08_11_000004_create_tickets_table.php
Schema::create('tickets', function (Blueprint $table) {
    $table->id();
    $table->string('titre');
    $table->text('description');
    $table->enum('statut', ['ouvert', 'en_cours', 'ferme'])->default('ouvert');
    $table->enum('priorite', ['basse', 'moyenne', 'haute'])->default('moyenne');
    $table->foreignId('createur_id')->constrained('users');
    $table->foreignId('assigne_a_id')->nullable()->constrained('users');
    $table->timestamps();
});

Schema::create('commentaires_ticket', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained();
    $table->text('contenu');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('commentaires_ticket');
    }
};
