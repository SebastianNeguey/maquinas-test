<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produccion;
use App\Models\Maquina;
use App\Helpers\ApiResponse;

class ProduccionController extends Controller
{
    public function show($id)
    {
        $produccion= Maquina::with('produccion')->findOrFail($id);
        if(!$produccion) return response()->json(['message' => 'Máquina no encontrada'], 404);
        return ApiResponse::success($produccion->produccion);
    }
}
