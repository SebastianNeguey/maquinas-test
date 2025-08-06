<?php

namespace App\Services;

use App\Models\Tarea;
use App\Models\Produccion;
use App\Models\Maquina;
use App\Services\InactividadService;

class TareaService
{
    public static function completarTarea(Tarea $tarea):void
    {
        $coef = $tarea->maquina->coeficiente;
        $tarea->tiempo_produccion = round($tarea->tiempo_empleado * $coef, 2);
        $tarea->estado = 'COMPLETADA';
        $tarea->save();
    }

    public static function evaluarProduccion(int $maquinaId)
    {
        $tareas = Tarea::where('maquina_id', $maquinaId)
            ->where('estado', 'COMPLETADA')
            ->whereNull('id_produccion')
            ->latest('fecha_hora_termino')
            ->take(5)
            ->get();

        if ($tareas->count() == 5) {
            $maquina = Maquina::findOrFail($maquinaId);
            $total = round($tareas->sum('tiempo_produccion'), 2);

            $produccion = Produccion::create([
                'maquina_id' => $maquina->id,
                'tiempo_produccion' => $total
            ]);

            foreach ($tareas as $t) {
                $t->id_produccion = $produccion->id;
                $t->save();
            }

            // Genera inactividad
            $respuesta= InactividadService::generar($produccion);
            return $respuesta;
            //if($respuesta) return "Producccion y Inactividad generada";
            //else{ return "Error";}
        }
        return 'No hay 5 tareas completadas';
    }
}