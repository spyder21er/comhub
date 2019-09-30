<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('origin_id');
            $table->unsignedBigInteger('destination_id');
            $table->string('trip_code');
            $table->string('driver_compliance_code');
            $table->string('passenger_compliance_code');
            $table->dateTime('departure_time');
            $table->dateTime('estimated_arrival_time');
            $table->boolean('exclusive');
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
        Schema::dropIfExists('trips');
    }
}
