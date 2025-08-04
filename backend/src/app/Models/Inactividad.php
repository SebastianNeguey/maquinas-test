<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inactividad extends Model
{
    use HasFactory;

    protected $fillable = [
        'produccion_id',
        'fecha_hora_inicio_inactividad',
        'fecha_hora_termino_inactividad',
        'tiempo_inactividad',
    ];

    public function produccion()
    {
        return $this->belongsTo(Produccion::class);
    }
}
