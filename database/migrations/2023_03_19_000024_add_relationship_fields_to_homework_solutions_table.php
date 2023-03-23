<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToHomeworkSolutionsTable extends Migration
{
    public function up()
    {
        Schema::table('homework_solutions', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id', 'student_fk_8190602')->references('id')->on('clients');
            $table->unsignedBigInteger('homework_id')->nullable();
            $table->foreign('homework_id', 'homework_fk_8190623')->references('id')->on('homeworks');
        });
    }
}
