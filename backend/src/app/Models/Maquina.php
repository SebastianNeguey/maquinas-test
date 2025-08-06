<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquinas';

    protected $fillable = ['nombre', 'coeficiente'];

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
    public function producciones()
    {
        return $this->hasMany(Produccion::class);
    }

}
