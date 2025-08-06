<?php
namespace App\Services;

use App\Models\Produccion;
use Carbon\Carbon;

class InactividadService
{
    public static function generar(Produccion $produccion)
    {
        //Tiempo de producción
        $tiempo_produccion = $produccion->tiempo_produccion;

        // Obtener la fecha de la última tarea de esa producción
        $fecha = Carbon::parse($produccion->tareas()->latest('fecha_hora_termino')->first()->fecha_hora_termino);

        // Buscar siguiente día hábil
        do {
            $fecha->addDay();
        } while ($fecha->isWeekend());

        $acumulado = 0;
        $inicio_global = null;
        $fin_global = null;

        //Se busca el siguiente dia hábil(lunes a viernes)
        while ($acumulado < $tiempo_produccion) {
            if ($fecha->isWeekend()) {
                $fecha->addDay();
                continue;
            }

            // Inicio aleatorio entre 9:00 y 14:00 si es el primer día, luego siempre 9:00
            $hora_inicio = $inicio_global ? 9 : rand(9, 14);
            $inicio = $fecha->copy()->setTime($hora_inicio, 0);//Hora de inicio del día
            $fin = $fecha->copy()->setTime(16, 0);//Hora de termino del día

            $horas_dia = $inicio->floatDiffInHours($fin);

            //Si no hay tiempo util en el día pasa al siguiente
            if ($horas_dia <= 0) {
                $fecha->addDay();
                continue;
            }

            $es_miercoles = $fecha->isWednesday();

            // Penalización por miércoles
            if ($es_miercoles) {
                $horas_dia = min($horas_dia, 4.5);
                $horas_dia -= 2.5;
            } elseif ($horas_dia < 5) {
                $horas_dia -= 1.5;
            }

            $horas_dia = max(0, $horas_dia); // Aegura que el valor no sea negativo despues de la penalización

            // Verifiica si el tiempo restante es menor que lo que vamos a usar hoy
            $restante = $tiempo_produccion - $acumulado;
            if ($restante <= 1.5) {
                $horas_dia = $restante;
            }
            
            // Se guarda la fecha de inicio de la inactividad
            if ($acumulado === 0) {
                $inicio_global = $inicio->copy();
            }
            // Se acumulan las horas producidas en este día
            $acumulado += $horas_dia;
            // Se calcula la hora final para esta jornada de inactividad
            $fin_global = $fecha->copy()->setTime(9, 0)->addHours((int)round($horas_dia));
            // Se avanza al día siguiente
            $fecha->addDay();
        }
        //Se actuliza produccion para almacenar fecha de inicio, fecha de termino y tiempo de inactividad
        $produccion->update([
            'fecha_hora_inicio_inactividad' => $inicio_global,
            'fecha_hora_termino_inactividad' => $fin_global,
            'tiempo_inactividad' => round($acumulado, 2),
        ]);
        return true;
        }
        
}