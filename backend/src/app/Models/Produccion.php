<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion';

    protected $fillable = [
        'maquina_id',
        'tiempo_produccion',
        'tiempo_inactividad',
        'fecha_hora_inicio_inactividad',
        'fecha_hora_termino_inactividad',
    ];

    public function tareas()
{
    return $this->hasMany(Tarea::class, 'id_produccion');
}

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }
}
