<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;


class CrearVehiculo extends FormRequest
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
            "dominio" => "required|min:5|max:10|unique:vehiculos",
            "marca" => "required|max:50",
            "modelo" => "required|max:50",
            "anio" => "required|integer|min:1990|max:2025",
            "kms_cada_service" => "nullable|integer",
            "kms_cada_cambio_bujias" => "nullable|integer",
            "kms_cada_rotacion_cubiertas" => "nullable|integer",
            "kms_cada_cambio_cubiertas" => "nullable|integer",
            "kms_cada_cambio_correa_distr" => "nullable|integer",
            "fecha_vto_vtv" => "nullable|date_format:d/m/Y|after:today",
            "fecha_vto_oblea_gnc" => "nullable|date_format:d/m/Y|after:today",

            "costo_mensual_imp_automotor" => "required_with:debito_patentes|numeric|gt:0",
            "dia_del_mes_debito_imp_automotor" => "required_with:debito_patentes|integer|min:1|max:28",

            "id_proveedor_seguro" => "required_with:debito_seguro|integer|exists:proveedores,id",
            "fecha_vto_poliza_seguro" => "required_with:debito_seguro|date_format:d/m/Y",
            "costo_mensual_seguro" => "required_with:debito_seguro|numeric|gt:0",
            "dia_del_mes_debito_seguro" => "required_with:debito_seguro|integer|min:1|max:28",

            // Campos de formulario alta nuevo vehiculo
            "kilometraje_actual" => "required|integer",
            "kms_ult_service" => "required|integer|lte:kilometraje_actual",
            "kms_ult_cambio_bujias" => "required|integer|lte:kilometraje_actual",
            "kms_ult_rotacion_cubiertas" => "required|integer|lte:kilometraje_actual",
            "kms_ult_cambio_cubiertas" => "required|integer|lte:kilometraje_actual",
            "kms_ult_cambio_correa_distr" => "required|integer|lte:kilometraje_actual"
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

            // Convertimos fechas de d/m/Y a Y-m-d antes de que el controller maneje la request porque el fill() de eloquent necesita Y-m-d aparentemente
            if($this->fecha_vto_vtv) {
                $this->merge(["fecha_vto_vtv" => Carbon::createFromFormat("d/m/Y", $this->fecha_vto_vtv)->format("Y-m-d")]);
            }

            if($this->fecha_vto_oblea_gnc) {
                $this->merge(["fecha_vto_oblea_gnc" => Carbon::createFromFormat("d/m/Y", $this->fecha_vto_oblea_gnc)->format("Y-m-d")]);
            }

            if($this->fecha_vto_poliza_seguro) {
                $this->merge(["fecha_vto_poliza_seguro" => Carbon::createFromFormat("d/m/Y", $this->fecha_vto_poliza_seguro)->format("Y-m-d")]);
            }

            // Mayusculas para patente del vehiculo
            $this->merge(["dominio" => strtoupper($this->dominio)]);
        }

        
    }



}
