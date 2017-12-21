<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });

        app(config('laraback.models.setting'))->create([
            'key' => 'example',
            'value' => 'Hello World!',
        ]);

        app(config('laraback.models.permission'))->createGroup('Settings', ['Edit Settings']);
    }

    public function down()
    {
        Schema::dropIfExists('settings');

        app(config('laraback.models.permission'))->where('group', 'Settings')->delete();
    }
}