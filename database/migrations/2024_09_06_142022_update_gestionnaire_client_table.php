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
        // $oldRelations = DB::table('gestionnaire_client')->get();

        // foreach ($oldRelations as $relation) {
        //     DB::table('gestionnaire_client_pivot')
        //         ->updateOrInsert(
        //             [
        //                 'client_id' => $relation->client_id,
        //                 'gestionnaire_id' => $relation->gestionnaire_id,
        //             ],
        //             [
        //                 'is_principal' => true,
        //                 'created_at' => $relation->created_at,
        //                 'updated_at' => $relation->updated_at,
        //             ]
        //         );
        // }
    }

    public function down(): void
    {
        // Optionally, you might want to restore the old data structure
        // This is a placeholder and should be implemented based on your needs
        DB::table('gestionnaire_client_pivot')->truncate();
    }
};
