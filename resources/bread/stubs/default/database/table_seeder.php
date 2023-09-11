<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\bread_model_class;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;

class bread_model_classesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        bread_model_class::factory(20)->create();
    }
}
