<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TareaPendiente extends Model
{
	
    const TIPO_RENOV_LICENCIA_CHOFER = "renov_licencia_chofer";
    const TIPO_TRABAJO_VEHICULAR = "trabajo_veh_programado";
    const TIPO_VTV = "vtv";
    const TIPO_VERIF_GNC = "verif_gnc";
    const TIPO_RENOV_SEGURO = "renovacion_seguro";
    const TIPO_ACTUALIZ_KMS = "actualizacion_kms";


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tareas_pendientes';

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
        'fecha_a_realizar',
        'fecha_a_notificar'
    ];


    /**
     * Crear query scope para filtrar por tipo de trabajo vehicular dado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeTrabajoVehicular($query, $tipoTrabajo)
    {
        return $query->where("tipo", self::TIPO_TRABAJO_VEHICULAR)
            ->where("tipo_trabajo_vehicular", $tipoTrabajo);
    }


}
