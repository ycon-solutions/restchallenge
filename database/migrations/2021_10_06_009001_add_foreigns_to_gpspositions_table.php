<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToGpspositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gpspositions', function (Blueprint $table) {
            $table
                ->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gpspositions', function (Blueprint $table) {
            $table->dropForeign(['shipment_id']);
        });
    }
}
