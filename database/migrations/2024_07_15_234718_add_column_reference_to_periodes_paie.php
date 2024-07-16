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
        Schema::table('periodes_paie', function (Blueprint $table) {
            $table->string('reference')->nullable()->after('id');
        });

        // Generate references for existing records
        // $periodes = PeriodesPaie::all();
        // foreach ($periodes as $periode) {
        //     $periode->reference = $periode->generateReference();
        //     $periode->save();
        // }
    }

    public function down()
    {
        Schema::table('periodes_paie', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }
};
