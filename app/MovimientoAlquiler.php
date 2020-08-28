<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;


class MovimientoAlquiler extends Model
{
    
    use Filterable;

    /**
     * Tipos de movimiento.
     */
    const TIPO_COBRO_ALQUILER = "cobro_alquiler";
    const TIPO_PAGO_DE_CHOFER = "pago_de_chofer";
    const TIPO_DESCUENTO = "descuento";


    /**
     * Medios de pago (sólo si tipo = TIPO_PAGO_DE_CHOFER)
     */
    const MEDIO_PAGO_EFECTIVO = "efectivo";
    const MEDIO_PAGO_TRANSFERENCIA = "transferencia";
    const MEDIO_PAGO_MERCADOPAGO = "mercadopago";


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movimientos_alquiler';


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
        'fecha_hora',
    ];


    /**
     * Obtener alquiler de este movimiento de alquiler.
     * @return App\Alquiler
     */
    public function alquiler()
    {
        return $this->belongsTo("App\Alquiler", "id_alquiler");
    }  


    /**
     * Ordenamiento de más antiguo a más reciente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaAsc($query)
    {
        return $query->orderBy("fecha_hora", "ASC")->orderBy("id", "ASC");
    }

    /**
     * Ordenamiento de más reciente a más antiguo
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaDesc($query)
    {
        return $query->orderBy("fecha_hora", "DESC")->orderBy("id", "DESC");
    }


    /**
     * Filtrar movimiento de alquiler por tipo pago de chofer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePagosDeChofer($query)
    {
        return $query->where("tipo", self::TIPO_PAGO_DE_CHOFER);
    }



    /**
     * Filtrar movimiento de alquiler por mes y año
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnMesYAnio($query, $mes, $anio)
    {
        return $query->whereMonth("fecha_hora", $mes)->whereYear("fecha_hora", $anio);
    }



    /**
     * Si este movimiento es por un cobro de alquiler al chofer.
     * @return bool
     */
    public function esCobroDeAlquiler()
    {
        return $this->tipo == self::TIPO_COBRO_ALQUILER;
    }


    /**
     * Si este movimiento es por un pago a cuenta del chofer.
     * @return bool
     */
    public function esPagoDeChofer()
    {
        return $this->tipo == self::TIPO_PAGO_DE_CHOFER;
    }


    /**
     * Si este movimiento es por un descuento a la cuenta del alquiler.
     * @return bool
     */
    public function esDescuento()
    {
        return $this->tipo == self::TIPO_DESCUENTO;
    }


    /**
     * Si el movimiento es con medio de pago de mercadopago
     * @return bool
     */
    public function esPorMercadopago()
    {
        return $this->medio_pago == self::MEDIO_PAGO_MERCADOPAGO;
    }


    /**
     * Si el movimiento es con medio de pago en efectivo
     * @return bool
     */
    public function esEnEfectivo()
    {
        return $this->medio_pago == self::MEDIO_PAGO_EFECTIVO;
    }

    /**
     * Si el movimiento es con medio de pago de transferencia bancaria
     * @return bool
     */
    public function esPorTransferencia()
    {
        return $this->medio_pago == self::MEDIO_PAGO_TRANSFERENCIA;
    }

}
