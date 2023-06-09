<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckStationsTable extends Migration
{
    public function up()
    {
        Schema::create('check_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
