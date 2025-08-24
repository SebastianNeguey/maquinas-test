<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // si en algún momento manejas auth puedes ajustarlo
    }

    public function rules(): array
    {
        return [
            'id_maquina' => 'required|exists:maquinas,id',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after:fecha_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'id_maquina.required' => 'El campo maquina_id es obligatorio.',
            'id_maquina.exists' => 'La máquina seleccionada no existe.',
            'fecha_inicio.required' => 'La fecha y hora de inicio son obligatorias.',
            'fecha_inicio.date' => 'La fecha y hora de inicio deben tener un formato válido.',
            'fecha_termino.required' => 'La fecha y hora de término son obligatorias.',
            'fecha_termino.date' => 'La fecha y hora de término deben tener un formato válido.',
            'fecha_termino.after' => 'La fecha y hora de término debe ser posterior a la de inicio.',
        ];
    }
}

