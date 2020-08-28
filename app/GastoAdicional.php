<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;


class GastoAdicional extends Model
{

    use Filterable;

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
     * Obtener vehiculo relacionado a este gasto. (incluir elementos eliminados)
     * @return App\Vehiculo
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo")->withTrashed();
    }   


    /**
     * Obtener proveedor relacionado a este gasto. (incluyendo eliminados)
     * @return App\Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor")->withTrashed();
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


    /**
     * Ordenar por más reciente a más antiguo.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdenReciente($query)
    {
        return $query->orderBy("fecha", "DESC")->orderBy("id", "DESC");
    }

    
}
