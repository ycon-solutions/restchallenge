<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpspositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gpspositions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('longitude');
            $table->double('latitude');
            $table->dateTime('utc_timestamp');
            $table->unsignedBigInteger('shipment_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gpspositions');
    }
}
