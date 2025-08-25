<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\MaquinaRequest;
use App\Http\Controllers\Controller;
use App\Models\Maquina;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponse;

class MaquinaController extends Controller
{
    public function index()
    {
        $maquinas = Maquina::all();
        return response()->json($maquinas);
    }
    public function store(MaquinaRequest $request)
    {
        try {
            $maquina = Maquina::create($request->validated());

            return ApiResponse::success('Máquina creada exitosamente.', $maquina, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear la máquina: ' . $e->getMessage());
            return ApiResponse::error('No se pudo crear la máquina', 500);
        }
    }

    public function show($id)
    {
        $maquina = Maquina::with(['tareas', 'produccion'])->find($id);

        if (!$maquina) {
            return response()->json(['message' => 'Máquina no encontrada'], 404);
        }

        return response()->json($maquina);
    }

    public function update(MaquinaRequest $request, Maquina $maquina)
    {
        $maquina->update($request->validated());

        return ApiResponse::success('Máquina actualizada correctamente.', $maquina);
    }

    public function destroy(Maquina $maquina)
    {
        $maquina->delete();

        return response()->noContent();
    }
}

