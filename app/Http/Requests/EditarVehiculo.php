<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Vehiculo;


class EditarVehiculo extends FormRequest
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
        $vehiculo = Vehiculo::findOrFail(\Route::current()->parameters()["vehiculo"]);

        return [
            "dominio" => "required|min:5|max:10|unique:vehiculos,dominio,".$vehiculo->id,
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

            "costo_mensual_imp_automotor" => "required_with:debito_patentes",
            "dia_del_mes_debito_imp_automotor" => "required_with:debito_patentes",

            "id_proveedor_seguro" => "required_with:debito_seguro|exists:proveedores,id",
            "fecha_vto_poliza_seguro" => "required_with:debito_seguro|date_format:d/m/Y",
            "costo_mensual_seguro" => "required_with:debito_seguro",
            "dia_del_mes_debito_seguro" => "required_with:debito_seguro|integer|min:1|max:28"
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

            $this->merge(["dominio" => strtoupper($this->dominio)]);
        }

        
    }



}
