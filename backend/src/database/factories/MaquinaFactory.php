<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaquinaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'coeficiente' => $this->faker->randomFloat(2, 0.1, 5),
        ];
    }
}
