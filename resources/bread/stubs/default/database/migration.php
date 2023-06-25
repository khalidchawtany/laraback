<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        // create bread_model_variables table
        Schema::create('bread_model_variables', function (Blueprint $table) {
            $table->increments('id');
            /* bread_schema */
            $table->timestamps();

            /* bread_foreign */
        });
    }

    public function down(): void
    {
        // drop bread_model_variables table
        Schema::dropIfExists('bread_model_variables');
    }
};
