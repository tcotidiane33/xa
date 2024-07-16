<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('periodes_paie', function (Blueprint $table) {
        //     $table->string('reference')->nullable()->after('id');
        // });

        Schema::table('traitements_paie', function (Blueprint $table) {
            $table->string('reference')->nullable()->after('id');
        });

        // Génération de références pour chaque table
        // $this->generateReferences('periodes_paie', 'PDP');
        $this->generateReferences('traitements_paie', 'TDP');
    }

    public function down()
    {
        // Schema::table('periodes_paie', function (Blueprint $table) {
        //     $table->dropColumn('reference');
        // });

        Schema::table('traitements_paie', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }

    // Fonction pour générer les références basées sur des colonnes spécifiques
    private function generateReferences($table, $prefix)
    {
        $rows = DB::table($table)->get();
        foreach ($rows as $row) {
            $clientName = DB::table('clients')->where('id', $row->client_id)->value('name');
            // if ($clientName) {
            //     if ($table == 'periodes_paie') {
            //         $date = \Carbon\Carbon::parse($row->fin)->format('Ymd');
            //     } else {
                    $date = \Carbon\Carbon::now()->format('Ymd'); // Si pas de date spécifique, utiliser la date actuelle
            //     }
                $reference = $prefix . '_' . strtoupper(substr($clientName, 0, 4)) . '_' . $date;
                DB::table($table)->where('id', $row->id)->update(['reference' => $reference]);
            // }
        }
    }
};
