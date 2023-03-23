<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSectionClientPivotTable extends Migration
{
    public function up()
    {
        Schema::create('class_section_client', function (Blueprint $table) {
            $table->unsignedBigInteger('class_section_id');
            $table->foreign('class_section_id', 'class_section_id_fk_8190588')->references('id')->on('class_sections')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id', 'client_id_fk_8190588')->references('id')->on('clients')->onDelete('cascade');
        });
    }
}
