<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearChofer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nombre_y_apellido" => "required|max:100",
            "telefono" => "nullable|max:40",
            "direccion" => "nullable|max:50",
            "dni" => "nullable|max:30",
            "fecha_vto_licencia" => "nullable|date_format:d/m/Y",
            "notas" => "nullable|max:200"
        ];
    }
}
