<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maquina;

class MaquinaController extends Controller
{
    public function index()
    {
        return Maquina::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'coeficiente' => 'required|numeric|min:0.1',
        ]);

        return Maquina::create($request->all());
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
