<?php

use Faker\Generator as Faker;

$factory->define(App\bread_model_class::class, function (Faker $faker) {

    $users = App\User::all()->take(5)->pluck('id');

    return [

        /* bread_factory */

        'user_id' => $users->random(),

    ];
});