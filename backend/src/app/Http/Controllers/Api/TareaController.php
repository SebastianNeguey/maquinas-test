<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Maquina;
use App\Services\TareaService;
use App\Helpers\ApiResponse; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public function store(Request $request)
    {   
        try{
            $request->validate([
                'id_maquina' => 'required|exists:maquinas,id',
                'fecha_inicio' => 'required|date',
                'fecha_termino' => 'required|date|after:fecha_inicio',
            ], [
                'id_maquina.required' => 'El campo maquina_id es obligatorio.',
                'id_maquina.exists' => 'La máquina seleccionada no existe.',
                'fecha_inicio.required' => 'La fecha y hora de inicio son obligatorias.',
                'fecha_inicio.date' => 'La fecha y hora de inicio deben tener un formato válido.',
                'fecha_termino.required' => 'La fecha y hora de término son obligatorias.',
                'fecha_termino.date' => 'La fecha y hora de término deben tener un formato válido.',
                'fecha_termino.after' => 'La fecha y hora de término debe ser posterior a la de inicio.',
            ]);

             // Calcular tiempo_empleado en horas decimales (con 2 decimales)
            $inicio = Carbon::parse($request->fecha_inicio);
            $fin = Carbon::parse($request->fecha_termino);
            $tiempo_empleado = round($inicio->floatDiffInHours($fin), 2);

            if ($tiempo_empleado < 5 || $tiempo_empleado > 120) {
                throw new \Exception('El tiempo empleado debe estar entre 5 y 120 horas');
            }

            //Obtener datos de Maquina
            $maquina = Maquina::find($request->id_maquina);
            if (!$maquina) {
                throw new \Exception('La maquina no existe');
            }

            //Creacion de tarea
            $tarea = new Tarea();
            $tarea->maquina_id = $request->id_maquina;
            $tarea->fecha_hora_inicio = $request->fecha_inicio;
            $tarea->fecha_hora_termino = $request->fecha_termino;
            $tarea->tiempo_empleado = $tiempo_empleado;
            $tarea->estado = 'PENDIENTE';
            $tarea->save();

            $respuesta= TareaService::evaluarProduccion($tarea->maquina_id);
            if(!$respuesta) return ApiResponse::error('Error con la produccion o inactividad', 500);
            return response()->json([
                'id' => $tarea->id,
                'fecha_inicio' => $tarea->fecha_hora_inicio,
                'fecha_termino' => $tarea->fecha_hora_termino,
                'estado' => $tarea->estado
            ]);
        } catch (\Exception $e) {
             Log::error('Error al crear tarea: ' . $e->getMessage());
            return ApiResponse::error('No se pudo crear la tarea', 500);
        }
    }

    public function show($id)
    {
        $maquina = Maquina::with('tareas')->findOrFail($id);
        if(!$maquina) return response()->json(['message' => 'Máquina no encontrada'], 404);
        $datos = $maquina->tareas->map(function($tarea) {
                return [
                    'id' => $tarea->id,
                    'fecha_inicio' => $tarea->fecha_hora_inicio,
                    'fecha_termino' => $tarea->fecha_hora_termino,
                    'estado' => $tarea->estado,
                ];
        });
        return response()->json($datos);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->noContent();
    }
}
