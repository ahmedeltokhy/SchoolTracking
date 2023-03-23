<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBusStationsTable extends Migration
{
    public function up()
    {
        Schema::table('bus_stations', function (Blueprint $table) {
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id', 'bus_fk_8181107')->references('id')->on('buses');
        });
    }
}
