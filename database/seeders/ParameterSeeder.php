<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameter;

class ParameterSeeder extends Seeder
{
    public function run()
    {
        Parameter::factory()->count(10)->create();
    }
}
