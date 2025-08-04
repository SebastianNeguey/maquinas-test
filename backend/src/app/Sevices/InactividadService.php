<?php
namespace App\Services;

use App\Models\Inactividad;
use App\Models\Produccion;
use Carbon\Carbon;

class InactividadService
{
    public static function generar(Produccion $produccion)
    {
        $tiempo_produccion = $produccion->tiempo_total_produccion;

        $fecha = Carbon::parse($produccion->tareas()->latest('fecha_hora_termino')->first()->fecha_hora_termino);
        do {
            $fecha->addDay();
        } while ($fecha->isWeekend());

        $acumulado = 0;
        $inicio_global = null;
        $fin_global = null;

        while ($acumulado < $tiempo_produccion) {
            if ($fecha->isWeekend()) {
                $fecha->addDay();
                continue;
            }

            $es_miercoles = $fecha->isWednesday();
            $inicio = $inicio_global ? Carbon::createFromTime(9, 0) : Carbon::createFromTime(rand(9, 14), 0);
            $fin = Carbon::createFromTime(16, 0);

            $horas_dia = $inicio->diffInHours($fin);

            if ($es_miercoles) {
                $horas_dia = min($horas_dia, 4.5);
                $horas_dia = max(0, $horas_dia - 2.5);
            } elseif ($horas_dia < 5) {
                $horas_dia = max(0, $horas_dia - 1.5);
            }

            $restante = $tiempo_produccion - $acumulado;
            if ($restante <= 1.5) {
                $horas_dia = $restante;
            }

            if ($acumulado === 0) {
                $inicio_global = $inicio->copy();
            }

            $acumulado += $horas_dia;
            $fin_global = $fin->copy();

            if ($acumulado >= $tiempo_produccion) break;

            $fecha->addDay();
        }

        return Inactividad::create([
            'produccion_id' => $produccion->id,
            'fecha_hora_inicio_inactividad' => $inicio_global,
            'fecha_hora_termino_inactividad' => $fin_global,
            'tiempo_inactividad' => round($acumulado, 2),
        ]);
    }
}