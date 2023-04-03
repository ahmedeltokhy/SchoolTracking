<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCheckStationsTable extends Migration
{
    public function up()
    {
        Schema::table('check_stations', function (Blueprint $table) {
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id', 'bus_fk_8274433')->references('id')->on('buses');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_8274434')->references('id')->on('clients');
            $table->unsignedBigInteger('bus_station_id')->nullable();
            $table->foreign('bus_station_id', 'bus_station_fk_8274435')->references('id')->on('bus_stations');
        });
    }
}
