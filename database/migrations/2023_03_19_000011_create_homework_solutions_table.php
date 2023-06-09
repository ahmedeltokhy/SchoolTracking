<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkSolutionsTable extends Migration
{
    public function up()
    {
        Schema::create('homework_solutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
