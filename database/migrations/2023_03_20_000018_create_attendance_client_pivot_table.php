<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceClientPivotTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_client', function (Blueprint $table) {
            $table->unsignedBigInteger('attendance_id');
            $table->foreign('attendance_id', 'attendance_id_fk_8213403')->references('id')->on('attendances')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id', 'client_id_fk_8213403')->references('id')->on('clients')->onDelete('cascade');
            $table->boolean('status')->default(0);

        });
    }
}
