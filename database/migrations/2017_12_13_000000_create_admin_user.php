<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Migration
{
    public function up()
    {
        app(config('auth.providers.users.model'))->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);
    }

    public function down()
    {
        //
    }
}