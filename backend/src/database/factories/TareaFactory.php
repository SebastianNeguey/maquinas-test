<?php

namespace Database\Factories;

use App\Models\Tarea;
use App\Models\Maquina;
use App\Models\Produccion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TareaFactory extends Factory
{
    protected $model = Tarea::class;

    public function definition(): array
    {
        // Creamos una fecha de inicio aleatoria
        $inicio = $this->faker->dateTimeBetween('-10 days', '-1 days');
        // Creamos una fecha de término posterior entre 5 y 48 horas
        $termino = (clone $inicio)->modify('+' . rand(5, 48) . ' hours');

        $tiempo_empleado = round(($termino->getTimestamp() - $inicio->getTimestamp()) / 3600, 2);

        return [
            'maquina_id' => Maquina::factory(),
            'id_produccion' => Produccion::factory(), // si Produccion no tiene factory, se puede poner `null`
            'fecha_hora_inicio' => Carbon::instance($inicio),
            'fecha_hora_termino' => Carbon::instance($termino),
            'tiempo_empleado' => $tiempo_empleado,
            'tiempo_produccion' => $this->faker->randomFloat(2, 0, $tiempo_empleado), // coherente
            'estado' => $this->faker->randomElement(['PENDIENTE', 'COMPLETADA']),
        ];
    }
}
