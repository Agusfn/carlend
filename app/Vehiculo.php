<?php

namespace App;

use App\TrabajoVehiculo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ActualizacionKmVehiculo;
use App\Lib\Vehiculos\RegistraKilometraje;

class Vehiculo extends Model
{
    use SoftDeletes, RegistraKilometraje;
    


    /**
     * Cada cuántos días se debe actualizar el kilometraje del auto a partir del primer ingreso.
     */
    const DIAS_ENTRE_CADA_ACTUALIZ_KMS = 14;

    /**
     * Dias mas/menos de tolerancia respecto de la fecha programada en el que se puede hacer el ingreso de KMs
     */
    const DIAS_TOLERANCIA_INGRESO_KMS = 3;


    /**
     * Variables de arriba pero en segundos. (no cambiar)
     */
    const SEGS_ENTRE_CADA_ACTUALIZ_KMS = self::DIAS_ENTRE_CADA_ACTUALIZ_KMS * 24 * 60 * 60;
    const SEGS_TOLERANCIA_INGRESO_KMS = self::DIAS_TOLERANCIA_INGRESO_KMS * 24 * 60 * 60;

    


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
        'fecha_vto_vtv',
        'fecha_vto_oblea_gnc',
        'fecha_vto_poliza_seguro'
    ];



    /**
     * Obtener alquiler actual del vehículo.
     * @return App\Alquiler|null
     */
    public function alquilerActual()
    {
        return $this->belongsTo("App\Alquiler", "id_alquiler_actual");
    }    


    /**
     * Obtener el proveedor de seguro actual
     * @return App\Proveedor|null
     */
    public function proveedorSeguro()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor_seguro");
    }



    /**
     * Obtener las actualizaciones de Kms del vehiculo.
     */
    public function actualizacionesKms()
    {
        return $this->hasMany("App\ActualizacionKmVehiculo", "id_vehiculo");
    }


    /**
     * Obtener los trabajos de este vehículo
     */
    public function trabajos()
    {
        return $this->hasMany("App\TrabajoVehiculo", "id_vehiculo");
    }


    /**
     * Obtener las tareas pendientes (notificaciones) relacionadas a este vehículo
     * @return [type] [description]
     */
    public function tareasPendientes()
    {
        return $this->hasMany("App\TareaPendiente", "id_vehiculo");
    }


    /**
     * Obtener query builder de trabajos previos (o iniciales) de vehiculo.
     * @return [type] [description]
     */
    public function trabajosPrevios()
    {
        return $this->trabajos()->where("es_trabajo_previo", true);
    }


    /**
     * Si el vehiculo tiene registrado el débito automático de pago de patentes
     * @return bool
     */
    public function tieneDebitoAutomPatentes()
    {
        return ($this->costo_mensual_imp_automotor && $this->dia_del_mes_debito_imp_automotor);
    } 

    /**
     * Si el vehiculo tiene registrado el debito automático del pago de seguro
     * @return bool
     */
    public function tieneDebitoAutomSeguro()
    {
        return $this->id_proveedor_seguro ? true : false;
    }   


    /**
     * Obtener marca, modelo y dominio. Ej: Ford Focus (MMH 997)
     * @return string
     */
    public function marcaModeloYDominio()
    {
        return $this->marca." ".$this->modelo." (".$this->dominio.")";
    }


    /**
     * Ordenar por nombre de marca y modelo ascendiente.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNombreAsc($query)
    {
        return $query->orderBy("marca", "ASC")->orderBy("modelo", "ASC");
    }


    /**
     * Crear los trabajos iniciales (que necesitan de una reposicion periódica y tienen notificaciones) de este vehiculo.
     * Llamado únicamente se da de alta un vehiculo.
     * @param  [type] $kmsCambioCorrea [description]
     * @return [type]                  [description]
     */
    public function registrarTrabajosIniciales($kmsService, $kmsBujias, $kmsRotacionRuedas, $kmsCambioCubiertas, $kmsCambioCorreaDistr)
    {
        $this->registrarTrabajoPrevio($kmsService, TrabajoVehiculo::SERVICE);
        $this->registrarTrabajoPrevio($kmsBujias, TrabajoVehiculo::CAMBIO_BUJIAS);
        $this->registrarTrabajoPrevio($kmsRotacionRuedas, TrabajoVehiculo::ROTACION_RUEDAS);
        $this->registrarTrabajoPrevio($kmsCambioCubiertas, TrabajoVehiculo::CAMBIO_CUBIERTAS);
        $this->registrarTrabajoPrevio($kmsCambioCorreaDistr, TrabajoVehiculo::CAMBIO_CORREA_DISTR);
    }


    /**
     * Registrar un trabajo previo sobre un vehiculo (solo se usa para trabajos notificables)
     * @param  [type] $kilometraje [description]
     * @param  [type] $tipoTrabajo [description]
     * @return [type]              [description]
     */
    public function registrarTrabajoPrevio($kilometraje, $tipoTrabajo)
    {
        TrabajoVehiculo::create([
            "es_trabajo_previo" => true,
            "id_vehiculo" => $this->id,
            "kms_vehiculo_estimados" => $kilometraje,
            "tipo" => $tipoTrabajo,
            "costo_total" => 0,
            "medio_pago" => "n/a"
        ]);

        // No actualizamos las tareas (notificaciones) de este trabajo porque el trabajo previo se registra
        // cuando se da de alta un vehiculo, y no se puede estimar cuándo será el próximo sin otro ingreso de kilometraje.
    }


    /**
     * Registrar un nuevo trabajo (no inicial) para este vehículo.
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function registrarTrabajo($params)
    {
        // crear nuevo trabajo
        
        // si el trabajo es notificable
            // actualizar notificaciones de este tipo de trabajo
    }


    /**
     * Actualizar las tareas (notificaciones) de un tipo de trabajo sobre este vehiculo
     * Elimina notificación anterior y crea una nueva con la fecha estimada a realizar actualizada.
     * @param  [type] $tipoTrabajo [description]
     * @return [type]                [description]
     */
    public function actualizarNotifsDeTrabajo($tipoTrabajo)
    {

        $this->borrarTareasPendientesDeTrabajo($tipoTrabajo);


        if(!TrabajoVehiculo::esTrabajoNotificable($tipoTrabajo))
            return;

        if(!$frecuenciaKms = $this->frecuenciaKmsPorTipoTrabajo($tipoTrabajo))
            return;

        if(!$this->puedeEstimarKilometraje())
            return;


        $ultimoTrabajo = $this->trabajos()->where("tipo", $tipoTrabajo)->last();

        $kmsProxTrabajo = $ultimoTrabajo->kms_vehiculo_estimados + $frecuenciaKms;
        
        $fechaEstimada = $this->estimarFechaDesdeKilometraje($kmsProxTrabajo);


        TareaPendiente::create([
            "id_vehiculo" => $this->id,
            "fecha_a_realizar" => $fechaEstimada,
            "tipo" => TareaPendiente::TIPO_TRABAJO_VEHICULAR,
            "tipo_trabajo_vehicular" => $tipoTrabajo,
            "descripcion" => "",
            "fecha_a_notificar" => $fechaEstimada->subDays(7),
            "notificado" => false
        ]);
        
    }



    /**
     * Borrar todas las tareas pendientes de este vehiculo
     * @return null
     */
    private function borrarTareasPendientesDeTrabajo($tipoTrabajo)
    {
        $tareas = $this->tareasPendientes()->deTrabajoVehicular($tipoTrabajo)->get();

        foreach($tareas as $tarea)
        {
            $tarea->delete();
        }
    }


    /**
     * Obtener la frecuencia en kilómetros de un tipo de trabajo para este vehiculo.
     * Se obtiene de un atributo del mismo vehiculo.    
     * @param  string $tipoTrabajo
     * @return int
     */
    public function frecuenciaKmsPorTipoTrabajo($tipoTrabajo)
    {
        return $this->{TrabajoVehiculo::$attrsTrabajosNotificables[$tipoTrabajo]};
    }

}
