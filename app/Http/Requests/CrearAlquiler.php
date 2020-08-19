<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Chofer;
use App\Vehiculo;
use Carbon\Carbon;

class CrearAlquiler extends FormRequest
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
            "fecha_fin" => "required_without:alquiler_indefinido|date_format:d/m/Y|after:today",
            "id_chofer" => "required|integer",
            "id_vehiculo" => "required|integer",
            "precio_diario" => "required|numeric|min:0",
            "notas" => "nullable|max:200"
        ];
    }


    /**
     * Llamado después de la validación
     * @return null
     */
    public function afterValidation($validator)
    {

        // Validación adicional

        if(!$validator->errors()->has("id_chofer"))
        {
            if(!Chofer::disponibles()->find($this->id_chofer)) {
                $validator->errors()->add("id_chofer", "No se encontró el chofer disponible ingresado.");
            }
        }

        if(!$validator->errors()->has("id_vehiculo"))
        {
            if(!Vehiculo::disponibles()->find($this->id_vehiculo)) {
                $validator->errors()->add("id_vehiculo", "No se encontró el vehículo disponible ingresado.");
            }
        }


        // Convertimos fechas de d/m/Y a Y-m-d antes de que el controller maneje la request porque el fill() de eloquent necesita Y-m-d aparentemente
        if($this->fecha_fin && !$validator->errors()->has("fecha_fin"))
        {
            $this->merge([
                "fecha_fin" => Carbon::createFromFormat("d/m/Y", $this->fecha_fin)->format("Y-m-d") 
            ]);
        }

    }


}
