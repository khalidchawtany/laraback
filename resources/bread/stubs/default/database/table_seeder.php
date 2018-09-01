<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \Spatie\Permission\Models\Role;

class bread_model_classesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\bread_model_class::class, 20)->create();
    }
}