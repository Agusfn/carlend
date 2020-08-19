<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\TrabajoVehiculo;
use Carbon\Carbon;
use App\Vehiculo;


class CrearTrabajoVehiculo extends FormRequest
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
            "id_vehiculo" => "required|integer|exists:vehiculos,id",
            "tipo" => [
                "required",
                Rule::in(TrabajoVehiculo::$tiposTrabajos)
            ],
            "observaciones" => "max: 191",
            "id_proveedor" => "nullable|integer|exists:proveedores,id",
            "fecha_pagado" => "required|date_format:d/m/Y|after_or_equal:".Carbon::today()->subDays(7)->format("Y-m-d")."|before_or_equal:today",
            "costo_total" => "required|numeric",
            "medio_pago" => "required|in:efectivo,tarjeta_credito,transferencia",
            "fecha_realizado" => "required|date_format:d/m/Y|after_or_equal:".Carbon::today()->subDays(7)->format("Y-m-d")."|before_or_equal:today",
            "kms_vehiculo_estimados" => "nullable|integer"
        ];
    }


    /**
     * Llamado después de la validación
     * @return null
     */
    public function afterValidation($validator)
    {

        // Validación adicional

        if(!$validator->errors()->has("id_vehiculo"))
        {
            $vehiculo = Vehiculo::findOrFail($this->id_vehiculo);

            if(!$this->kms_vehiculo_estimados) {

                if(!$vehiculo->puedeEstimarKilometraje()) {
                    $validator->errors()->add("kms_vehiculo_estimados", "Se debe ingresar el kilometraje porque el vehiculo no puede estimarlo.");
                }

            }
        }


        // Convertimos fechas de d/m/Y a Y-m-d antes de que el controller maneje la request porque el fill() de eloquent necesita Y-m-d aparentemente
        if(!$validator->failed())
        {
            $this->merge([
                "fecha_pagado" => Carbon::createFromFormat("d/m/Y", $this->fecha_pagado)->format("Y-m-d"),
                "fecha_realizado" => Carbon::createFromFormat("d/m/Y", $this->fecha_realizado)->format("Y-m-d")
            ]);
        }


    }


}
