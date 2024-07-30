<?php

namespace Database\Factories;

use App\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParameterFactory extends Factory
{
    protected $model = Parameter::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'type' => $this->faker->randomElement([1, 2]),
        ];
    }
}
