<?php

namespace Tests\Feature;

use App\Models\Maquina;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('crea una máquina correctamente', function () {
    $payload = [
        'nombre' => 'Cortadora Laser',
        'coeficiente' => 1.25,
    ];

    $response = $this->postJson('/api/maquinas', $payload);

    $response->assertCreated()
             ->assertJsonFragment([
                 'nombre' => 'Cortadora Laser',
                 'coeficiente' => 1.25,
             ]);

    $this->assertDatabaseHas('maquinas', [
        'nombre' => 'Cortadora Laser',
        'coeficiente' => 1.25,
    ]);
});

it('falla al crear máquina sin nombre o coeficiente', function () {
    $response = $this->postJson('/api/maquinas', []);

    $response->assertStatus(422)
             ->assertJsonStructure([
                 'message',
                 'error' => ['nombre', 'coeficiente']
             ])
             ->assertJsonFragment([
                 'nombre' => ['The nombre field is required.'],
                 'coeficiente' => ['The coeficiente field is required.'],
             ]);
});

it('muestra una máquina existente', function () {
    $maquina = Maquina::factory()->create();

    $response = $this->getJson("/api/maquinas/{$maquina->id}");

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $maquina->id,
                 'nombre' => $maquina->nombre,
             ]);
});

it('actualiza una máquina existente', function () {
    $maquina = Maquina::factory()->create([
        'nombre' => 'Antigua',
        'coeficiente' => 0.8,
    ]);

    $payload = ['nombre' => 'Nueva'];

    $response = $this->putJson("/api/maquinas/{$maquina->id}", $payload);

    $response->assertOk()
             ->assertJsonFragment([
                 'nombre' => 'Nueva',
             ]);

    $this->assertDatabaseHas('maquinas', [
        'id' => $maquina->id,
        'nombre' => 'Nueva',
    ]);
});

it('elimina una máquina existente', function () {
    $maquina = Maquina::factory()->create();

    $response = $this->deleteJson("/api/maquinas/{$maquina->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('maquinas', [
        'id' => $maquina->id,
    ]);
});

