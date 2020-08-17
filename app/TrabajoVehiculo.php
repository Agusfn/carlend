<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrabajoVehiculo extends Model
{
    
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
     * Obtener vehiculo relacionado a este trabajo.
     * @return App\Vehiculo
     */
    public function vehiculo()
    {
        return $this->belongsTo("App\Vehiculo", "id_vehiculo");
    }   


    /**
     * Obtener proveedor relacionado a este trabajo.
     * @return App\Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor");
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
     * Si el tipo de trabajo es notificable.
     * @param  string $tipoTrabajo
     * @return bool
     */
    public static function esTrabajoNotificable($tipoTrabajo)
    {
        return in_array($tipoTrabajo, array_keys(self::$attrsTrabajosNotificables));
    }


}
