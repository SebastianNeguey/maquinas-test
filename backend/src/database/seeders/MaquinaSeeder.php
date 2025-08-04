<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maquina;

class MaquinaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Maquina::create([
                'nombre' => 'Máquina ' . $i,
                'coeficiente' => round(mt_rand(10, 30) / 10, 1), // entre 1.0 y 3.0
            ]);
        }
    }
}
