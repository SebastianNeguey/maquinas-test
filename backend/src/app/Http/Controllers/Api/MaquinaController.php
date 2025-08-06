<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maquina;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;

class MaquinaController extends Controller
{
    public function index()
    {
        return Maquina::all();
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'nombre' => 'required|string',
            'coeficiente' => 'required|numeric|min:0.1',
        ]);

        Maquina::create($request->all());
        return ApiResponse::success('Maquina creada exitosamente.', 'ok', 201);
        } catch (\Exception $e) {
             Log::error('Error al crear la maquina: ' . $e->getMessage());
            return ApiResponse::error('No se pudo crear la maquina', 500);
        }
    }

    public function show(Maquina $maquina)
    {
        return $maquina;
    }

    public function update(Request $request, Maquina $maquina)
    {
        $maquina->update($request->all());
        return $maquina;
    }

    public function destroy(Maquina $maquina)
    {
        $maquina->delete();
        return response()->noContent();
    }
    
}
