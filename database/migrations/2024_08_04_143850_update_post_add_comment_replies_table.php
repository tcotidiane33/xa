<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->json('attachments')->nullable()->comment("JSON array of file paths"); // Ajout de pièces jointes
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->text('content')->nullable(); // Ajout du contenu des commentaires
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Ajout de la clé étrangère pour l'utilisateur
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->text('content')->nullable(); // Ajout du contenu des réponses
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Ajout de la clé étrangère pour l'utilisateur
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('attachments'); // Suppression de la colonne des pièces jointes
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('content'); // Suppression de la colonne du contenu des commentaires
            $table->dropForeign(['user_id']); // Suppression de la clé étrangère pour l'utilisateur
            $table->dropColumn('user_id'); // Suppression de la colonne de l'utilisateur
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropColumn('content'); // Suppression de la colonne du contenu des réponses
            $table->dropForeign(['user_id']); // Suppression de la clé étrangère pour l'utilisateur
            $table->dropColumn('user_id'); // Suppression de la colonne de l'utilisateur
        });
    }
};
