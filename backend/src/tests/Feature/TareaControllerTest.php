<?php

namespace Tests\Feature;

use App\Models\Tarea;
use App\Models\Maquina;
use Illuminate\Support\Carbon;

it('crea una tarea válida', function () {
    $maquina = Maquina::factory()->create();

    $payload = [
        'id_maquina' => $maquina->id,
        'fecha_inicio' => now()->subHours(10)->toDateTimeString(),
        'fecha_termino' => now()->toDateTimeString(),
    ];

    $response = $this->postJson('/api/tareas', $payload);

    $response->assertStatus(200)
        ->assertJsonStructure(['id', 'fecha_inicio', 'fecha_termino', 'estado']);
});

it('rechaza tarea con fechas inválidas', function () {
    $maquina = Maquina::factory()->create();

    $payload = [
        'id_maquina' => $maquina->id,
        'fecha_inicio' => now()->toDateTimeString(),
        'fecha_termino' => now()->subHours(5)->toDateTimeString(), // anterior al inicio
    ];

    $response = $this->postJson('/api/tareas', $payload);

    $response->assertStatus(422)
         ->assertJsonPath('error.fecha_termino', fn ($errors) => count($errors) > 0);
});

it('muestra tareas de una maquina', function () {
    $maquina = Maquina::factory()->create();
    Tarea::factory()->count(2)->create([
        'maquina_id' => $maquina->id,
    ]);

    $response = $this->getJson("/api/tareas/{$maquina->id}");

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJsonStructure([
            '*' => ['id', 'fecha_inicio', 'fecha_termino', 'estado']
        ]);
});

it('elimina una tarea', function () {
    $tarea = Tarea::factory()->create();

    $response = $this->deleteJson("/api/tareas/{$tarea->id}");

    $response->assertNoContent();

    expect(Tarea::find($tarea->id))->toBeNull();
});

