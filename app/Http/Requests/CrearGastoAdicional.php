<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\GastoAdicional;
use Carbon\Carbon;

class CrearGastoAdicional extends FormRequest
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
            "fecha" => "required|date_format:d/m/Y|after_or_equal:-31day|before_or_equal:today",
            "tipo" => [
                "required",
                "string",
                Rule::in(GastoAdicional::$tipos)
            ],
            "detalle" => "nullable|max:60",
            "id_vehiculo" => "nullable|integer|exists:vehiculos,id",
            "monto" => "required|numeric|gt:0",
            "medio_pago" => "required|in:efectivo,tarjeta_credito,transferencia",
            "id_proveedor" => "nullable|integer|exists:proveedores,id"
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
            $this->merge([
                "fecha" => Carbon::createFromFormat("d/m/Y", $this->fecha)->format("Y-m-d")
            ]);
        }
        
    }

}
