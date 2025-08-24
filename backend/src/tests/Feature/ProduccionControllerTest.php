<?php

namespace Tests\Feature;

use App\Models\Maquina;
use App\Models\Produccion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduccionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_muestra_producciones_de_una_maquina()
    {
        // Crear máquina
        $maquina = Maquina::factory()->create();

        // Crear producciones
        $produccion1 = Produccion::factory()->create(['maquina_id' => $maquina->id]);
        $produccion2 = Produccion::factory()->create(['maquina_id' => $maquina->id]);

        // Llamar al endpoint
        $response = $this->getJson("/api/producciones/{$maquina->id}");

        $response->assertStatus(200)
                ->assertJsonCount(2) // Número de producciones
                ->assertJsonFragment(['id' => $produccion1->id])
                ->assertJsonFragment(['id' => $produccion2->id]);
    }


    public function test_maquina_no_encontrada_devuelve_404()
    {
        $response = $this->getJson("/api/producciones/999"); // id inexistente

        $response->assertStatus(404)
                 ->assertJsonFragment(['message' => 'Recurso no encontrado']);
    }

}
