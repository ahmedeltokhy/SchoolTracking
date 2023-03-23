<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id', 'teacher_fk_8190627')->references('id')->on('clients');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id', 'student_fk_8190628')->references('id')->on('clients');
            $table->unsignedBigInteger('classsection_id')->nullable();
            $table->foreign('classsection_id', 'classsection_fk_8190629')->references('id')->on('class_sections');
        });
    }
}
