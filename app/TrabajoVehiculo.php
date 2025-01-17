<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;


class TrabajoVehiculo extends Model
{
    
    use Filterable;

    // Tipos de trabajo
    const SERVICE = "service";
    const CAMBIO_BUJIAS = "cambio_bujias";
    const ROTACION_RUEDAS = "rotacion_ruedas";
    const CAMBIO_CUBIERTAS = "cambio_cubiertas";
    const CAMBIO_CORREA_DISTR = "cambio_correa_distr";    
    const CAMBIO_CORREA_ALTERN = "cambio_correa_altern";
    const CAMBIO_BATERIA = "cambio_bateria";
    const CAMBIO_FRENOS = "cambio_frenos";
    const REPARACION = "reparacion";
    const OTROS = "otros";


    /**
     * Tipos de trabajos disponibles
     * @var array
     */
    public static $tiposTrabajos = [
        self::SERVICE,
        self::CAMBIO_BUJIAS,
        self::ROTACION_RUEDAS,
        self::CAMBIO_CUBIERTAS,
        self::CAMBIO_CORREA_DISTR,
        self::CAMBIO_CORREA_ALTERN,
        self::CAMBIO_BATERIA,
        self::CAMBIO_FRENOS,
        self::REPARACION,
        self::OTROS,
    ];

    /**
     * Lista de cada tipo de trabajo notificable, y junto a cada uno, el nombre del atributo de Vehiculo que
     * contiene la frecuencia en KMs de dicho trabajo.
     * @var array
     */
    public static $attrsTrabajosNotificables = [
        self::SERVICE => "kms_cada_service",
        self::CAMBIO_BUJIAS => "kms_cada_cambio_bujias",
        self::ROTACION_RUEDAS => "kms_cada_rotacion_cubiertas",
        self::CAMBIO_CUBIERTAS => "kms_cada_cambio_cubiertas",
        self::CAMBIO_CORREA_DISTR => "kms_cada_cambio_correa_distr"
    ];



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trabajos_vehiculos';

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
        'fecha_pagado',
        'fecha_realizado'
    ];



    /**
     * Obtener vehiculo relacionado a este trabajo. (incluir elementos eliminados)
     * @return App\Vehiculo
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo")->withTrashed();
    }   


    /**
     * Obtener proveedor relacionado a este trabajo. (incluyendo eliminados)
     * @return App\Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor")->withTrashed();
    }    


    /**
     * Query scope para filtrar por los trabajos validos actuales, no los iniciales indicados por el usuario al dar el alta al vehiculo.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidos($query)
    {
        return $query->where("es_trabajo_previo", false);
    }


    /**
     * Ordenar por fecha de pago de más reciente a más antigua
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaDePagoDesc($query)
    {
        return $query->orderBy("fecha_pagado", "DESC")->orderBy("id", "DESC");
    }


    /**
     * Ordenar por fecha realizado de más reciente a más antigua
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaRealizadoDesc($query)
    {
        return $query->orderBy("fecha_realizado", "DESC")->orderBy("id", "DESC");
    }



    /**
     * Filtrar trabajo pagado en mes y año
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePagadoEnMesYAnio($query, $mes, $anio)
    {
        return $query->whereMonth("fecha_pagado", $mes)->whereYear("fecha_pagado", $anio);
    }

    /**
     * Filtrar trabajos con costo (no gratuitos)
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConCosto($query)
    {
        return $query->where("costo_total", ">", 0);
    }


    /**
     * Si el tipo de trabajo es notificable.
     * @param  string $tipoTrabajo
     * @return bool
     */
    public static function esTrabajoNotificable($tipoTrabajo)
    {
        return in_array($tipoTrabajo, array_keys(self::$attrsTrabajosNotificables));
    }


}
