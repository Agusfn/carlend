<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastoAdicional extends Model
{


    /**
     * Tipos de gastos.
     */
    const TIPO_PAGO_SEGURO_VEHICULO = "seguro_vehiculo";
    const TIPO_PAGO_IMPUESTO_VEHICULO = "impuesto_automotor";
    const TIPO_OTRO = "otro";


    /**
     * Medios de pago
     */
    const MEDIO_PAGO_EFECTIVO = "efectivo";
    const MEDIO_PAGO_TARJETA = "tarjeta_credito";
    const MEDIO_PAGO_TRANSFERENCIA = "transferencia";


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gastos_adicionales';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha',
    ];


    /**
     * Obtener vehiculo relacionado a este gasto.
     * @return App\Vehiculo
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo");
    }   


    /**
     * Obtener proveedor relacionado a este gasto.
     * @return App\Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor");
    }    

    /**
     * Filtrar gasto adicional por mes y año
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnMesYAnio($query, $mes, $anio)
    {
        return $query->whereMonth("fecha", $mes)->whereYear("fecha", $anio);
    }
    
}
