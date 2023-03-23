<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusClientPivotTable extends Migration
{
    public function up()
    {
        Schema::create('bus_client', function (Blueprint $table) {
            $table->unsignedBigInteger('bus_id');
            $table->foreign('bus_id', 'bus_id_fk_8181097')->references('id')->on('buses')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id', 'client_id_fk_8181097')->references('id')->on('clients')->onDelete('cascade');
        });
    }
}
