<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->afterValidation($validator);
        });
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nombre_y_apellido" => "required|string|max:100",
            "telefono" => "nullable|string|max:40",
            "direccion" => "nullable|string|max:50",
            "dni" => "nullable|string|max:30",
            "fecha_vto_licencia" => "nullable|date_format:d/m/Y",
            "notas" => "nullable|string|max:200"
        ];
    }



    /**
     * Llamado después de la validación
     * @return null
     */
    public function afterValidation($validator)
    {

        if(!$validator->failed())
        {            
            if($this->fecha_vto_licencia) 
            {
                $this->merge([
                    "fecha_vto_licencia" => Carbon::createFromFormat("d/m/Y", $this->fecha_vto_licencia)->format("Y-m-d")
                ]);
            }
        }
        
    }

}
