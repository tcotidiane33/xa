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
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('is_portfolio')->default(false);
            $table->unsignedBigInteger('parent_client_id')->nullable();
            $table->foreign('parent_client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('is_portfolio');
            $table->dropForeign(['parent_client_id']);
            $table->dropColumn('parent_client_id');
        });
    }
};
