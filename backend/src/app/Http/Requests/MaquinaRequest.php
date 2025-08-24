<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaquinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Aquí podrías poner lógica de permisos si usas roles
    }

    public function rules(): array
    {
        // Regla dinámica: si es POST (crear), los campos son obligatorios
        // si es PUT/PATCH (actualizar), se permiten "sometimes"
        if ($this->isMethod('post')) {
            return [
                'nombre' => 'required|string|max:255',
                'coeficiente' => 'required|numeric|min:0.1',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'nombre' => 'sometimes|required|string|max:255',
                'coeficiente' => 'sometimes|required|numeric|min:0.1',
            ];
        }

        return [];
    }
}

