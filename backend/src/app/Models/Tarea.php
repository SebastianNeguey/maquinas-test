<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';

    protected $fillable = [
        'maquina_id',
        'id_produccion',
        'fecha_hora_inicio',
        'fecha_hora_termino',
        'tiempo_empleado',
        'tiempo_produccion',
        'estado',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }

    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
