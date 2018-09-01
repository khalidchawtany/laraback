<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Createbread_model_classTable extends Migration
{
    public function up()
    {
        // create bread_model_variables table
        Schema::create('bread_model_variables', function (Blueprint $table) {
            $table->increments('id');
            /* bread_schema */
            $table->timestamps();
        });

    }

    public function down()
    {
        // drop bread_model_variables table
        Schema::dropIfExists('bread_model_variables');
    }
}
