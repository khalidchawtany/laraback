<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTimezone extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('timezone')->default(config('app.timezone'));
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
}