<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Maquina;

class TareaController extends Controller
{
    public function index()
    {
        return Tarea::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'maquina_id' => 'required|exists:maquinas,id',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_termino' => 'required|date|after:fecha_hora_inicio',
            'tiempo_empleado' => 'required|numeric|min:5|max:120',
        ]);

        $maquina = Maquina::findOrFail($request->maquina_id);

        $tarea = new Tarea();
        $tarea->maquina_id = $maquina->id;
        $tarea->fecha_hora_inicio = $request->fecha_hora_inicio;
        $tarea->fecha_hora_termino = $request->fecha_hora_termino;
        $tarea->tiempo_empleado = $request->tiempo_empleado;
        $tarea->tiempo_produccion = $request->tiempo_empleado * $maquina->coeficiente;
        $tarea->estado = 'COMPLETADA'; // según regla 5
        $tarea->save();

        // Verificar si hay 5 tareas completadas para esta máquina
        $ultimas = Tarea::where('maquina_id', $maquina->id)
            ->where('estado', 'COMPLETADA')
            ->latest('fecha_hora_termino')
            ->take(5)
            ->get();

        if ($ultimas->count() == 5) {
            // Crear producción
            $totalProduccion = $ultimas->sum('tiempo_produccion');

            $produccion = $maquina->producciones()->create([
                'tiempo_total_produccion' => $totalProduccion,
            ]);

            // Asociar tareas a la producción
            foreach ($ultimas as $t) {
                $t->id_produccion = $produccion->id;
                $t->save();
            }

            // Acá podrías invocar el cálculo de inactividad
            // InactividadService::generar($produccion);
        }

        return $tarea;
    }

    public function show(Tarea $tarea)
    {
        return $tarea;
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->noContent();
    }
}
