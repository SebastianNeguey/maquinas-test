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
    public function index()
    {
        return Tarea::all();
    }

    public function store(Request $request)
    {   
        try{
            $request->validate([
                'maquina_id' => 'required|exists:maquinas,id',
                'fecha_hora_inicio' => 'required|date',
                'fecha_hora_termino' => 'required|date|after:fecha_hora_inicio',
            ], [
                'maquina_id.required' => 'El campo maquina_id es obligatorio.',
                'maquina_id.exists' => 'La máquina seleccionada no existe.',
                'fecha_hora_inicio.required' => 'La fecha y hora de inicio son obligatorias.',
                'fecha_hora_inicio.date' => 'La fecha y hora de inicio deben tener un formato válido.',
                'fecha_hora_termino.required' => 'La fecha y hora de término son obligatorias.',
                'fecha_hora_termino.date' => 'La fecha y hora de término deben tener un formato válido.',
                'fecha_hora_termino.after' => 'La fecha y hora de término debe ser posterior a la de inicio.',
            ]);

             // Calcular tiempo_empleado en horas decimales (con 2 decimales)
            $inicio = Carbon::parse($request->fecha_hora_inicio);
            $fin = Carbon::parse($request->fecha_hora_termino);
            $tiempo_empleado = round($inicio->floatDiffInHours($fin), 2);

            if ($tiempo_empleado < 5 || $tiempo_empleado > 120) {
                throw new \Exception('El tiempo empleado debe estar entre 5 y 120 horas');
            }

            //Obtener datos de Maquina
            $maquina = Maquina::find($request->maquina_id);
            if (!$maquina) {
                throw new \Exception('La maquina no existe');
            }

            //Creacion de tarea
            $tarea = new Tarea();
            $tarea->maquina_id = $request->maquina_id;
            $tarea->fecha_hora_inicio = $request->fecha_hora_inicio;
            $tarea->fecha_hora_termino = $request->fecha_hora_termino;
            $tarea->tiempo_empleado = $tiempo_empleado;
            $tarea->estado = 'PENDIENTE';
            $tarea->tiempo_produccion = $tiempo_empleado* $maquina->coeficiente;
            $tarea->save();

            // Completar la tarea usando el service
            TareaService::completarTarea($tarea);

            // Evaluar si se deben generar producción e inactividad
            $respuesta= TareaService::evaluarProduccion($tarea->maquina_id);

            return ApiResponse::success('Tarea creada exitosamente.', $respuesta, 201); // Usamos el helper
        } catch (\Exception $e) {
             Log::error('Error al crear tarea: ' . $e->getMessage());
            return ApiResponse::error('No se pudo crear la tarea', 500);
        }
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
