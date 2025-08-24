<?php

namespace Database\Factories;

use App\Models\Maquina;
use App\Models\Produccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduccionFactory extends Factory
{
    protected $model = Produccion::class;

    public function definition(): array
    {
        return [
            'maquina_id' => Maquina::factory(),
            'tiempo_produccion' => $this->faker->numberBetween(10, 300),
            'tiempo_inactividad' => $this->faker->numberBetween(0, 50),
            'fecha_hora_inicio_inactividad' => now(),
            'fecha_hora_termino_inactividad' => now()->addMinutes(10),
        ];
    }
}
