<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToHomeworksTable extends Migration
{
    public function up()
    {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id', 'teacher_fk_8190594')->references('id')->on('clients');
            $table->unsignedBigInteger('class_section_id')->nullable();
            $table->foreign('class_section_id', 'class_section_fk_8190596')->references('id')->on('class_sections');
        });
    }
}
